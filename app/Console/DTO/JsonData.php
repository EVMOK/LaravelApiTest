<?php

namespace App\Console\DTO;

use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class JsonData extends DataTransferObject
{
    /** @var int */
    public $id;

    /** @var int */
    public $domain_id;

    /** @var string */
    public $subject;

    /** @var Carbon */
    public $unisender_send_date_at;

    /** @var Carbon */
    public $created_at;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(array $request): self
    {
        return new self([
            'id' => $request['id'],
            'domain_id' => $request['domain_id'],
            'subject' => $request['subject'],
            'unisender_send_date_at' => Carbon::make($request['unisender_send_date_at']),
            'created_at' => $request['created_at'] ? Carbon::make($request['created_at']) : null,
        ]);
    }
}
