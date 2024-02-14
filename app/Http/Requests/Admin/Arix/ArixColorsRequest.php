<?php

namespace Pterodactyl\Http\Requests\Admin\Arix;

use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class ArixColorsRequest extends AdminFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'arix:primary' => 'required|string',

            'arix:successText' => 'required|string',
            'arix:successBorder' => 'required|string',
            'arix:successBackground' => 'required|string',

            'arix:dangerText' => 'required|string',
            'arix:dangerBorder' => 'required|string',
            'arix:dangerBackground' => 'required|string',

            'arix:secondaryText' => 'required|string',
            'arix:secondaryBorder' => 'required|string',
            'arix:secondaryBackground' => 'required|string',

            'arix:gray50' => 'required|string',
            'arix:gray100' => 'required|string',
            'arix:gray200' => 'required|string',
            'arix:gray300' => 'required|string',
            'arix:gray400' => 'required|string',
            'arix:gray500' => 'required|string',
            'arix:gray600' => 'required|string',
            'arix:gray700' => 'required|string',
            'arix:gray800' => 'required|string',
            'arix:gray900' => 'required|string',


            'arix:lightmode_primary' => 'required|string',

            'arix:lightmode_successText' => 'required|string',
            'arix:lightmode_successBorder' => 'required|string',
            'arix:lightmode_successBackground' => 'required|string',

            'arix:lightmode_dangerText' => 'required|string',
            'arix:lightmode_dangerBorder' => 'required|string',
            'arix:lightmode_dangerBackground' => 'required|string',

            'arix:lightmode_secondaryText' => 'required|string',
            'arix:lightmode_secondaryBorder' => 'required|string',
            'arix:lightmode_secondaryBackground' => 'required|string',

            'arix:lightmode_gray50' => 'required|string',
            'arix:lightmode_gray100' => 'required|string',
            'arix:lightmode_gray200' => 'required|string',
            'arix:lightmode_gray300' => 'required|string',
            'arix:lightmode_gray400' => 'required|string',
            'arix:lightmode_gray500' => 'required|string',
            'arix:lightmode_gray600' => 'required|string',
            'arix:lightmode_gray700' => 'required|string',
            'arix:lightmode_gray800' => 'required|string',
            'arix:lightmode_gray900' => 'required|string',
        ];
    }
}