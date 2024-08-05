<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RomanNumeralController extends Controller
{
    /**
     * Array de valores de números romanos
     *
     * @var array
     */
    protected array $romanNumerals = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    ];

    /**
     * Manipula a conversão com base no tipo de conversão selecionado
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function manipularConversao(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'conversion_type' => 'required|in:roman_to_integer,integer_to_roman',
        ]);

        $number = strtoupper($request->input('number'));
        $conversionType = $request->input('conversion_type');

        if ($conversionType === 'roman_to_integer') {
            if (!$this->isValidRoman($number)) {
                return redirect('/')->with('error', 'Número Romano inválido ou contém caracteres não permitidos.');
            }
            $result = $this->convertRomanToInteger($number);
        } else {
            // Verificar se o número contém caracteres não permitidos
            if (!is_numeric($number) || (int)$number <= 0 || (int)$number > 3999) {
                return redirect('/')->with('error', 'Número inteiro inválido ou maior que 3999.');
            }
            $result = $this->convertIntegerToRoman((int)$number);
        }

        return redirect('/')->with('result', $result);
    }

    /**
     * Verifica se o número romano é válido e contém apenas caracteres permitidos
     *
     * @param string $roman
     * @return bool
     */
    private function isValidRoman(string $roman): bool
    {
        // Verifica se o número romano contém apenas caracteres válidos
        if (preg_match('/[^MDCLXVI]/', $roman)) {
            return false;
        }
        
        // Verifica se o número romano é válido conforme as regras
        return (bool) preg_match('/^(M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3}))$/', $roman);
    }

    /**
     * Converte número romano para inteiro
     *
     * @param string $roman
     * @return int
     */
    private function convertRomanToInteger(string $roman): int
    {
        $result = 0;
        $i = 0;

        while ($i < strlen($roman)) {
            if ($i + 1 < strlen($roman) && array_key_exists(substr($roman, $i, 2), $this->romanNumerals)) {
                $result += $this->romanNumerals[substr($roman, $i, 2)];
                $i += 2;
            } else {
                $result += $this->romanNumerals[$roman[$i]];
                $i++;
            }
        }

        return $result;
    }

    /**
     * Converte inteiro para número romano
     *
     * @param int $integer
     * @return string
     */
    private function convertIntegerToRoman(int $integer): string
    {
        $result = '';

        foreach ($this->romanNumerals as $roman => $value) {
            while ($integer >= $value) {
                $result .= $roman;
                $integer -= $value;
            }
        }

        return $result;
    }
}
