<?php

namespace App\Console\Commands;

use App\Console\DTO\JsonData;
use App\Models\Mails;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class JsonParseCommand extends Command
{
    /** @var LoggerInterface */
    protected $logger;
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'json:parse';
    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Разбивка файла по API';

    private const JSON_FILE = '/source/mails.json';

    public function handle(): int
    {
        $this->logger = Log::channel('syslog');

        try {
            $data = $this->getJsonData();
            $this->upsert($data);
            $this->deleteOldValues($data);
        } catch (Throwable $exception) {
            $this->logger->error("Error in command {$this->signature}", [
                'errorMessage' => $exception->getMessage(),
            ]);
        }
        $this->logger->info('Json parse success');

        return Command::SUCCESS;
    }

    private function getJsonData(): Collection
    {
        $jsonData = json_decode(file_get_contents(resource_path() . self::JSON_FILE), true);

        if (! $jsonData['data']) {
            $this->error('Data could not be fetched.');
        }

        return collect($jsonData['data']);
    }

    /**
     * @throws UnknownProperties
     */
    private function upsert(Collection $data): void
    {
        foreach ($data as $item) {
            $dataDto = JsonData::fromRequest($item);
            Mails::query()->updateOrCreate(
                ['id' => $dataDto->id],
                [
                    'domain_id' => $dataDto->domain_id,
                    'subject' => $dataDto->subject,
                    'unisender_send_date_at' => $dataDto->unisender_send_date_at,
                    'created_at' => $dataDto->created_at,
                ]
            );
        }
    }

    private function deleteOldValues(Collection $data): void
    {
        $newIds = $data->pluck('id')->all();
        $oldIds = array_diff(Mails::query()->pluck('id')->all(), $newIds);

        Mails::destroy($oldIds);
    }
}
