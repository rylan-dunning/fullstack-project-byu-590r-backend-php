<?php
namespace App\Console\Commands;

use App\Mail\VideogameRecommendations;
use App\Models\VideoGame;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendGameRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videogames:recommendations {--email=brdunning14@gmail.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends video game recommendations to users based on their preferences';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sendToEmail = $this->option('email');
        if (!$sendToEmail) {
            $this->error('Email address is required');
            return Command::FAILURE;
        }

        // Get recently added games with their ESRB ratings
        $recentGames = VideoGame::with(['esrbRating'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        if ($recentGames->count() > 0) {
            // Send email with game recommendations
            Mail::to($sendToEmail)->send(new VideogameRecommendations($recentGames));
            $this->info('Recommendations email sent successfully');
        } else {
            $this->info('No recent games found to recommend');
        }

        return Command::SUCCESS;
    }
}