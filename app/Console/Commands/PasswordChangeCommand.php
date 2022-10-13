<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class PasswordChangeCommand extends Command
{
    /** @var LoggerInterface */
    protected $logger;
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'password:change {email} {password} {newPassword}';
    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Смена пароля у пользователя';

    public function handle(): int
    {
        $this->logger = Log::channel('daily');

        $email = $this->argument('email');
        $password = $this->argument('password');
        $newPassword = $this->argument('newPassword');

        $user = User::where('email', User::find($email))->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            $this->logger->error('Предоставленные учетные данные неверны');

            return Command::FAILURE;
        }
        $this->logger->info('Password change command for user ' . $user->name);
        $user->forceFill([
            'password' => Hash::make($newPassword)
        ]);
        $user->save();

        return Command::SUCCESS;
    }
}
