<?php

namespace App\Http\Requests;

use App\Models\Notification;
use App\Rules\PersianPhoneRule;
use App\Rules\WithoutSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PushNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in($this->getValidMethods())],
            'to' => ['required', 'string', new WithoutSpaceRule(), $this->getMethodRule()],
            'message' => ['required', 'string', 'max:10000'],
            'name' => ['required', 'string', 'max:100']
        ];
    }

    private function getMethodRule(): string | PersianPhoneRule | null
    {
        $type = $this->get('type');
        return $type === config('notif.sms') ? new PersianPhoneRule() : 'email';
    }

    private function getValidMethods(): array {
        return [
        config('notif.sms'),
        config('notif.email')
        ];
    }
}
