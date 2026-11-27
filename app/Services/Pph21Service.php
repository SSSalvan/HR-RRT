<?php

namespace App\Services;

class Pph21Service
{
    /**
     * Mapping Status PTKP ke Kategori TER (PP 58/2023 & PMK 168/2023)
     */
    public static function getCategory(string $ptkpStatus): string
    {
        $ptkpStatus = strtoupper(trim($ptkpStatus));

        switch ($ptkpStatus) {
            case 'TK/0':
            case 'TK/1':
            case 'K/0':
                return 'A';

            case 'TK/2':
            case 'TK/3':
            case 'K/1':
            case 'K/2':
                return 'B';

            case 'K/3':
                return 'C';

            default:
                return 'A'; // Default jika belum diisi
        }
    }

    /**
     * Ambil tarif TER Bulanan berdasarkan Kategori dan Penghasilan Bruto
     * Sesuai Lampiran PP 58 Tahun 2023
     */
    public static function getTerRate(string $category, float $grossIncome): float
    {
        $category = strtoupper($category);

        if ($category === 'A') {
            return self::getRateCategoryA($grossIncome);
        } elseif ($category === 'B') {
            return self::getRateCategoryB($grossIncome);
        } elseif ($category === 'C') {
            return self::getRateCategoryC($grossIncome);
        }

        return self::getRateCategoryA($grossIncome);
    }

    /**
     * Hitung PPh 21 TER lengkap
     */
    public static function calculate(string $ptkpStatus, float $grossIncome): array
    {
        $category = self::getCategory($ptkpStatus);
        $rate = self::getTerRate($category, $grossIncome);
        $taxAmount = (int) round($grossIncome * $rate);

        return [
            'ptkp_status' => $ptkpStatus,
            'category' => $category,
            'rate' => $rate,
            'rate_percent' => ($rate * 100) . '%',
            'gross_income' => $grossIncome,
            'tax_amount' => $taxAmount,
        ];
    }

    /**
     * Tabel Tarif TER Kategori A (TK/0, TK/1, K/0)
     */
    private static function getRateCategoryA(float $income): float
    {
        if ($income <= 5400000) return 0.0;
        if ($income <= 5650000) return 0.0025;
        if ($income <= 5950000) return 0.005;
        if ($income <= 6300000) return 0.0075;
        if ($income <= 6750000) return 0.01;
        if ($income <= 7500000) return 0.0125;
        if ($income <= 8550000) return 0.015;
        if ($income <= 9650000) return 0.0175;
        if ($income <= 10050000) return 0.02;
        if ($income <= 10350000) return 0.0225;
        if ($income <= 10700000) return 0.025;
        if ($income <= 11050000) return 0.03;
        if ($income <= 11600000) return 0.035;
        if ($income <= 12500000) return 0.04;
        if ($income <= 13750000) return 0.05;
        if ($income <= 15100000) return 0.06;
        if ($income <= 16950000) return 0.07;
        if ($income <= 19750000) return 0.08;
        if ($income <= 24150000) return 0.09;
        if ($income <= 26450000) return 0.10;
        if ($income <= 28000000) return 0.11;
        if ($income <= 30050000) return 0.12;
        if ($income <= 32400000) return 0.13;
        if ($income <= 35400000) return 0.14;
        if ($income <= 39100000) return 0.15;
        if ($income <= 43850000) return 0.16;
        if ($income <= 47800000) return 0.17;
        if ($income <= 51400000) return 0.18;
        if ($income <= 56300000) return 0.19;
        if ($income <= 62200000) return 0.20;
        if ($income <= 68600000) return 0.21;
        if ($income <= 77500000) return 0.22;
        if ($income <= 89000000) return 0.23;
        if ($income <= 103000000) return 0.24;
        if ($income <= 125000000) return 0.25;
        if ($income <= 157000000) return 0.26;
        if ($income <= 206000000) return 0.27;
        if ($income <= 337000000) return 0.28;
        if ($income <= 454000000) return 0.29;
        if ($income <= 550000000) return 0.30;
        if ($income <= 695000000) return 0.31;
        if ($income <= 910000000) return 0.32;
        if ($income <= 1400000000) return 0.33;
        return 0.34;
    }

    /**
     * Tabel Tarif TER Kategori B (TK/2, TK/3, K/1, K/2)
     */
    private static function getRateCategoryB(float $income): float
    {
        if ($income <= 6200000) return 0.0;
        if ($income <= 6500000) return 0.0025;
        if ($income <= 6850000) return 0.005;
        if ($income <= 7300000) return 0.0075;
        if ($income <= 9200000) return 0.01;
        if ($income <= 10750000) return 0.015;
        if ($income <= 11250000) return 0.02;
        if ($income <= 11600000) return 0.025;
        if ($income <= 12600000) return 0.03;
        if ($income <= 13600000) return 0.04;
        if ($income <= 14950000) return 0.05;
        if ($income <= 16400000) return 0.06;
        if ($income <= 18450000) return 0.07;
        if ($income <= 21850000) return 0.08;
        if ($income <= 26000000) return 0.09;
        if ($income <= 27700000) return 0.10;
        if ($income <= 29350000) return 0.11;
        if ($income <= 31450000) return 0.12;
        if ($income <= 33950000) return 0.13;
        if ($income <= 37100000) return 0.14;
        if ($income <= 41100000) return 0.15;
        if ($income <= 45800000) return 0.16;
        if ($income <= 49500000) return 0.17;
        if ($income <= 53800000) return 0.18;
        if ($income <= 58500000) return 0.19;
        if ($income <= 64000000) return 0.20;
        if ($income <= 71000000) return 0.21;
        if ($income <= 80000000) return 0.22;
        if ($income <= 93000000) return 0.23;
        if ($income <= 109000000) return 0.24;
        if ($income <= 129000000) return 0.25;
        if ($income <= 163000000) return 0.26;
        if ($income <= 211000000) return 0.27;
        if ($income <= 374000000) return 0.28;
        if ($income <= 459000000) return 0.29;
        if ($income <= 555000000) return 0.30;
        if ($income <= 704000000) return 0.31;
        if ($income <= 957000000) return 0.32;
        if ($income <= 1405000000) return 0.33;
        return 0.34;
    }

    /**
     * Tabel Tarif TER Kategori C (K/3)
     */
    private static function getRateCategoryC(float $income): float
    {
        if ($income <= 6600000) return 0.0;
        if ($income <= 6950000) return 0.0025;
        if ($income <= 7350000) return 0.005;
        if ($income <= 7800000) return 0.0075;
        if ($income <= 8850000) return 0.01;
        if ($income <= 9800000) return 0.0125;
        if ($income <= 10950000) return 0.015;
        if ($income <= 11200000) return 0.0175;
        if ($income <= 12050000) return 0.02;
        if ($income <= 12950000) return 0.03;
        if ($income <= 14150000) return 0.04;
        if ($income <= 15550000) return 0.05;
        if ($income <= 17050000) return 0.06;
        if ($income <= 19500000) return 0.07;
        if ($income <= 22700000) return 0.08;
        if ($income <= 26600000) return 0.09;
        if ($income <= 28100000) return 0.10;
        if ($income <= 30100000) return 0.11;
        if ($income <= 32600000) return 0.12;
        if ($income <= 35400000) return 0.13;
        if ($income <= 38900000) return 0.14;
        if ($income <= 43000000) return 0.15;
        if ($income <= 47400000) return 0.16;
        if ($income <= 51200000) return 0.17;
        if ($income <= 55800000) return 0.18;
        if ($income <= 60400000) return 0.19;
        if ($income <= 66700000) return 0.20;
        if ($income <= 74500000) return 0.21;
        if ($income <= 83200000) return 0.22;
        if ($income <= 95600000) return 0.23;
        if ($income <= 110000000) return 0.24;
        if ($income <= 134000000) return 0.25;
        if ($income <= 169000000) return 0.26;
        if ($income <= 221000000) return 0.27;
        if ($income <= 390000000) return 0.28;
        if ($income <= 463000000) return 0.29;
        if ($income <= 561000000) return 0.30;
        if ($income <= 709000000) return 0.31;
        if ($income <= 965000000) return 0.32;
        if ($income <= 1419000000) return 0.33;
        return 0.34;
    }
}
