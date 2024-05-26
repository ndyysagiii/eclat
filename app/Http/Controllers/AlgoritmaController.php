<?php

namespace App\Http\Controllers;

use App\Models\EclatCalculation;
use App\Models\EclatResult;
use App\Models\EclatResultDetail;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlgoritmaController extends Controller
{
    public function index()
    {
        return view('layouts.pages.algoritma');
    }

    public function filter(Request $request)
    {
        $tanggal_dari = $request->input('tanggal_dari');
        $tanggal_sampai = $request->input('tanggal_sampai');
        $min_support = $request->input('min_support');
        $min_confidance = $request->input('min_confidance');

        $calculation = EclatCalculation::create([
            'tanggal_dari' => $tanggal_dari,
            'tanggal_sampai' => $tanggal_sampai,
            'min_support' => $min_support,
            'min_confidance' => $min_confidance,
        ]);

        $transaksi = Transaksi::with(['detail'])->whereBetween('tanggal_transaksi', [$tanggal_dari, $tanggal_sampai])->get();
        $dataVertikal = $this->convertToVerticalFormat($transaksi);

        if (empty($dataVertikal)) {
            return redirect()->route('algoritma')->with('message', 'Tidak ada itemset yang memenuhi ambang batas support yang ditentukan.');
        }
        $totalTransactions = $transaksi->count();
        list($oneItemsets, $twoItemsets, $threeItemsets) = $this->pruneItemsets($dataVertikal, $min_support, $totalTransactions);

        $rules = [];
        foreach ([$twoItemsets ?? [], $threeItemsets ?? []] as $itemsets) {
            foreach ($itemsets as $itemset => $supportCount) {
                $confidence = $this->calculateConfidence($itemset, $supportCount, $dataVertikal);
                if ($confidence >= $min_confidance) {
                    $liftRatio = $this->calculateLiftRatio($itemset, $supportCount, $dataVertikal, $totalTransactions);
                    $keterangan = $liftRatio > 1 ? 'lolos' : 'tidak lolos';
                    $rules[] = [
                        'itemset' => $itemset,
                        'support' => $supportCount / $totalTransactions,
                        'confidence' => $confidence,
                        'liftRatio' => $liftRatio,
                        'keterangan' => $keterangan,
                    ];

                    // Save Eclat Result
                    $eclatResult = EclatResult::create([
                        'eclat_calculation_id' => $calculation->id,
                        'itemset' => $itemset,
                        'support' => $supportCount / $totalTransactions,
                        'confidence' => $confidence,
                        'result_type' => count(explode(',', $itemset)) . '-itemset',
                        'keterangan' => $keterangan,
                        'lift_ratio' => $liftRatio,
                    ]);

                    // Save Eclat Result Details
                    foreach (explode(',', $itemset) as $obat_id) {
                        EclatResultDetail::create([
                            'eclat_calculation_id' => $calculation->id,
                            'eclat_result_id' => $eclatResult->id,
                            'obat_id' => $obat_id,
                        ]);
                    }
                }
            }
        }

        if (empty($rules)) {
            return redirect()->route('algoritma')->with('message', 'Tidak ada aturan yang memenuhi ambang batas confidence yang ditentukan.');
        }

        return view('layouts.pages.algoritma', compact('transaksi', 'totalTransactions', 'rules', 'dataVertikal'));
    }

    private function convertToVerticalFormat($transaksi)
    {
        $dataVertikal = [];

        foreach ($transaksi as $trans) {
            foreach ($trans->detail as $detail) {
                $dataVertikal[$detail->obat_id] = array_fill_keys($transaksi->pluck('id')->toArray(), 0);
            }
        }

        foreach ($transaksi as $trans) {
            foreach ($trans->detail as $detail) {
                $dataVertikal[$detail->obat_id][$trans->id] = 1;
            }
        }

        return $dataVertikal;
    }

    private function calculateSupport($itemset, $dataVertikal)
    {
        $intersected = array_fill_keys(array_keys(reset($dataVertikal)), 1);
        foreach ($itemset as $item) {
            $intersected = array_intersect_key($intersected, array_filter($dataVertikal[$item]));
        }
        return array_sum($intersected);
    }

    private function calculateConfidence($itemset, $supportCount, $dataVertikal)
    {
        $antecedent = array_slice(explode(',', $itemset), 0, -1);
        $denominator = $this->calculateSupport($antecedent, $dataVertikal);
        return $supportCount / $denominator;
    }

    private function calculateLiftRatio($itemset, $supportCount, $dataVertikal, $totalTransactions)
    {
        $items = explode(',', $itemset);
        $supportA = $this->calculateSupport([$items[0]], $dataVertikal) / $totalTransactions;
        $supportB = $this->calculateSupport([$items[1]], $dataVertikal) / $totalTransactions;
        $supportAB = $supportCount / $totalTransactions;

        return $supportAB / ($supportA * $supportB);
    }

    private function pruneItemsets($dataVertikal, $min_support, $totalTransactions)
    {
        $frequentItemsets = [];
        $min_support_count = $min_support * $totalTransactions;

        foreach ($dataVertikal as $item => $transactions) {
            $support = array_sum($transactions);
            if ($support >= $min_support_count) {
                $frequentItemsets[implode(',', [$item])] = $support;
            }
        }

        $twoItemsets = [];
        $frequentItemsetsKeys = array_keys($frequentItemsets);
        $frequentItemsetsCount = count($frequentItemsetsKeys);
        for ($i = 0; $i < $frequentItemsetsCount; $i++) {
            for ($j = $i + 1; $j < $frequentItemsetsCount; $j++) {
                $newItemset = array_unique(array_merge(explode(',', $frequentItemsetsKeys[$i]), explode(',', $frequentItemsetsKeys[$j])));
                sort($newItemset);
                if (count($newItemset) == 2) {
                    $support = $this->calculateSupport($newItemset, $dataVertikal);
                    if ($support >= $min_support_count) {
                        $twoItemsets[implode(',', $newItemset)] = $support;
                    }
                }
            }
        }

        $threeItemsets = [];
        $twoItemsetsKeys = array_keys($twoItemsets);
        $twoItemsetsCount = count($twoItemsetsKeys);
        for ($i = 0; $i < $twoItemsetsCount; $i++) {
            for ($j = $i + 1; $j < $twoItemsetsCount; $j++) {
                $newItemset = array_unique(array_merge(explode(',', $twoItemsetsKeys[$i]), explode(',', $twoItemsetsKeys[$j])));
                sort($newItemset);
                if (count($newItemset) == 3) {
                    $support = $this->calculateSupport($newItemset, $dataVertikal);
                    if ($support >= $min_support_count) {
                        $threeItemsets[implode(',', $newItemset)] = $support;
                    }
                }
            }
        }

        return [$frequentItemsets, $twoItemsets, $threeItemsets];
    }
}
