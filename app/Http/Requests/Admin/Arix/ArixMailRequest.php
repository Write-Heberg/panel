<?php

namespace Pterodactyl\Http\Requests\Admin\Arix;

use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class ArixMailRequest extends AdminFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'arix:mail_color' => 'required|string',
            'arix:mail_backgroundColor' => 'required|string',
            'arix:mail_logo' => 'required|string',
            'arix:mail_logoFull' => 'required|in:true,false',
            'arix:mail_mode' => 'required|string',

            'arix:mail_discord' => 'nullable|string',
            'arix:mail_twitter' => 'nullable|string',
            'arix:mail_facebook' => 'nullable|string',
            'arix:mail_instagram' => 'nullable|string',
            'arix:mail_linkedin' => 'nullable|string',
            'arix:mail_youtube' => 'nullable|string',

            'arix:mail_status' => 'nullable|string',
            'arix:mail_billing' => 'nullable|string',
            'arix:mail_support' => 'nullable|string',
        ];
    }
}