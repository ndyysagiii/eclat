<?php

namespace App\Http\Controllers;

use App\Models\EclatResult;
use App\Models\EclatResultDetail;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class DashboardController extends Controller
{
    public function index()
    {
        return view('layouts.pages.dashboard');
    }
    private function eclat($transaksi, $min_support)
    {
        $tidlists = [];
        foreach ($transaksi as $tid => $trans) {
            foreach ($trans->detail as $detail) {
                if (!isset($tidlists[$detail->obat_id])) {
                    $tidlists[$detail->obat_id] = [];
                }
                $tidlists[$detail->obat_id][] = $tid;
            }
        }

        $items = [];
        foreach ($tidlists as $item => $tids) {
            $items[] = [$item, $tids];
        }

        $freq_itemsets = [];
        $this->eclatRecursive([], $items, $min_support * count($transaksi), $freq_itemsets);

        return $freq_itemsets;
    }

    private function eclatRecursive($prefix, $items, $min_support, &$freq_itemsets)
    {
        while (!empty($items)) {
            list($item, $tids) = array_pop($items);
            $support = count($tids);
            if ($support >= $min_support) {
                $new_prefix = array_merge($prefix, [$item]);
                $freq_itemsets[implode(',', $new_prefix)] = $support;
                $suffix = [];
                foreach ($items as $other) {
                    list($other_item, $other_tids) = $other;
                    $new_tids = array_intersect($tids, $other_tids);
                    if (count($new_tids) >= $min_support) {
                        $suffix[] = [$other_item, $new_tids];
                    }
                }
                $this->eclatRecursive($new_prefix, $suffix, $min_support, $freq_itemsets);
            }
        }
    }

    private function generateAssociationRules($freq_itemsets, $min_confidence, $total_transactions, $tanggal_dari, $tanggal_sampai)
    {
        $rules = [];
        foreach ($freq_itemsets as $itemset => $support) {
            $items = explode(',', $itemset);
            if (count($items) > 1) {
                foreach ($items as $item) {
                    $remain_items = array_diff($items, [$item]);
                    $remain_itemset = implode(',', $remain_items);
                    if (isset($freq_itemsets[$remain_itemset])) {
                        $confidence = $support / $freq_itemsets[$remain_itemset];
                        if ($confidence >= $min_confidence) {
                            $support_remain_item = $freq_itemsets[$remain_itemset] / $total_transactions;
                            $support_pair = $support / $total_transactions;

                            $support_item = $this->calculateSupportX($item, $tanggal_dari, $tanggal_sampai) / $total_transactions;

                            $lift_ratio = $support_pair / ($support_item * $support_remain_item);
                            $korelasi = $lift_ratio > 1 ? 'positif' : 'negatif';

                            $rules[] = [
                                'itemset' => $itemset,
                                'support' => $support_pair,
                                'confidence' => $confidence,
                                'lift_ratio' => $lift_ratio,
                                'korelasi' => $korelasi,
                                'lolos' => $confidence >= $min_confidence
                            ];
                        } else {
                            // Tambahkan log atau pesan kesalahan
                            $rules[] = [
                                'itemset' => $itemset,
                                'support' => $support / $total_transactions,
                                'confidence' => $confidence,
                                'error' => 'Confidence tidak memenuhi min_confidence'
                            ];
                        }
                    } else {
                        // Tambahkan log atau pesan kesalahan
                        $rules[] = [
                            'itemset' => $itemset,
                            'support' => $support / $total_transactions,
                            'error' => 'Itemset tidak ditemukan dalam freq_itemsets'
                        ];
                    }
                }
            } else {
                // Tambahkan log atau pesan kesalahan
                $rules[] = [
                    'itemset' => $itemset,
                    'support' => $support / $total_transactions,
                    'error' => 'Itemset kurang dari 2 item'
                ];
            }
        }
        return $rules;
    }

    private function saveToDatabase($tanggal_dari, $tanggal_sampai, $min_support, $min_confidance, $rules)
    {
        // Membuka transaksi database tunggal
        DB::beginTransaction();

        try {
            foreach ($rules as $rule) {
                $itemset = explode(',', $rule['itemset']);
                $itemsetCount = count($itemset);

                $supportX = $this->calculateSupportX($itemset[0], $tanggal_dari, $tanggal_sampai);
                $supportXY = $this->calculateSupportXY($itemset, $tanggal_dari, $tanggal_sampai);

                $eclatResult = EclatResult::create([
                    'tanggal_dari' => $tanggal_dari,
                    'tanggal_sampai' => $tanggal_sampai,
                    'min_support' => $min_support,
                    'min_confidance' => $min_confidance,
                    'itemset' => $rule['itemset'],
                    'support' => $rule['support'],
                    'support_x' => $supportX,
                    'support_xy' => $supportXY,
                    'confidence' => $rule['confidence'],
                    'result_type' => $itemsetCount . '-item',
                    'lolos' => $rule['lolos']
                ]);

                $this->saveEclatResultDetails($eclatResult, $itemset);
            }

            // Commit transaksi database
            DB::commit();
            return redirect()->back()->with('message', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data. Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function calculateSupportX($itemId, $tanggal_dari, $tanggal_sampai)
    {
        // Hitung jumlah transaksi mengandung item X
        $supportX = Transaksi::whereBetween('tanggal_transaksi', [$tanggal_dari, $tanggal_sampai])
            ->whereHas('detail', function ($query) use ($itemId) {
                $query->where('obat_id', $itemId);
            })
            ->count();

        return $supportX;
    }

    private function calculateSupportXY($itemset, $tanggal_dari, $tanggal_sampai)
    {
        // Hitung jumlah transaksi mengandung item X dan Y
        $supportXY = Transaksi::whereBetween('tanggal_transaksi', [$tanggal_dari, $tanggal_sampai])
            ->whereHas('detail', function ($query) use ($itemset) {
                foreach ($itemset as $itemId) {
                    $query->where('obat_id', $itemId);
                }
            })
            ->count();

        return $supportXY;
    }

    private function calculateSupportXYZ($itemset, $tanggal_dari, $tanggal_sampai)
    {
        // Hitung jumlah transaksi mengandung item X, Y, dan Z
        $supportXYZ = Transaksi::whereBetween('tanggal_transaksi', [$tanggal_dari, $tanggal_sampai])
            ->whereHas('detail', function ($query) use ($itemset) {
                foreach ($itemset as $itemId) {
                    $query->where('obat_id', $itemId);
                }
            })
            ->count();

        return $supportXYZ;
    }

    private function saveEclatResultDetails(EclatResult $eclatResult, $itemset)
    {
        foreach ($itemset as $itemId) {
            EclatResultDetail::create([
                'eclat_result_id' => $eclatResult->id,
                'obat_id' => $itemId,
            ]);
        }
    }
    // $frequent_itemsets = $this->eclat($transaksi, $min_support);
    // $rules = $this->generateAssociationRules($frequent_itemsets, $min_confidance, $jumlah_data, $tanggal_dari, $tanggal_sampai);
    // // dd($rules);
    // // Simpan hasil ke dalam database
    // $this->saveToDatabase($tanggal_dari, $tanggal_sampai, $min_support, $min_confidance, $rules);
}
