<?php
/**
 * When clicked change status fee_payment_completed to 'Y'
 * input data_jso w/ contest_id participant_id
 */

use Illuminate\Support\Facades\Gate;

?>

<div>
    <form wire:submit.prevent="participantPaymentCompleted">
        @csrf
        <input type="hidden" wire:fill="contest_id" name="contest_id"
            value="{{ $contest_id }}" readonly />

        <input type="hidden" wire:fill="participant_id" name="participant_id"
            value="{{ $participant_id }}" readonly />

        <div class="small">{{ ($feePaymentCompleted === 'Y') ? __("✅ Payment completed") : __("🟨 Waiting payment receive") }}</div>

        @foreach ($errors->all() as $message)
        <div class="alert alert-danger small">{{$message}}</div>
        @endforeach

        <button type="submit"
            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __("Change Payment status") }}
        </button>
    </form>
</div>
