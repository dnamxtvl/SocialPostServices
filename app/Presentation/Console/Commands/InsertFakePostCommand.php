<?php

namespace App\Presentation\Console\Commands;

use App\Infrastructure\Models\IndividualComment;
use App\Infrastructure\Models\IndividualMediaFile;
use App\Infrastructure\Models\IndividualPost;
use App\Infrastructure\Models\IndividualPostEmoji;
use App\Infrastructure\Models\User;
use Illuminate\Console\Command;
use Throwable;
use App\Domain\User\Enums\UserStatusEnum;

class InsertFakePostCommand extends Command
{
    const chunkSize = 200;
    const numberPostOfUser = 3;
    const numberMediaFileOfPost = 5;
    const numberCommentOfPost = 5;
    const numberEmojiOfPost = 10;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fake-multiple-individual-post-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $countUser = User::query()->where('status', UserStatusEnum::ACTIVE->value)->count();
        $bar = $this->output->createProgressBar($countUser / self::chunkSize);
        $postArray = [];
        $postMediaFile = [];
        $postComment = [];
        $emojiOfPostArray = [];
        $bar->start();

        try {
            User::query()->where('status', UserStatusEnum::ACTIVE->value)
                ->chunk(self::chunkSize, function ($users) use (
                    &$postArray, &$postMediaFile, &$postComment, &$emojiOfPostArray, &$bar
                ) {
                foreach ($users as $user) {
                    for ($i = 0; $i < self::numberPostOfUser; $i++) {
                        $postArray[] = $this->getArrayIndividualPost(userId: $user->id);
                    }
                }
                foreach ($postArray as $post) {
                    for ($i = 0; $i < self::numberMediaFileOfPost; $i++) {
                        $postMediaFile[] = $this->getIndividualMediaFile(
                            postId: $post['id'], userId: $postArray[array_rand($postArray)]['user_id']
                        );
                    }
                    for ($i = 0; $i < self::numberCommentOfPost; $i++) {
                        $postComment[] = $this->getIndividualComment(
                            postId: $post['id'], userId: $postArray[array_rand($postArray)]['user_id']
                        );
                    }
                    for ($i = 0; $i < self::numberEmojiOfPost; $i++) {
                        $emojiOfPostArray[] = $this->getIndividualEmoji(
                            postId: $post['id'], userId: $postArray[array_rand($postArray)]['user_id']
                        );
                    }
                }

                IndividualPost::query()->insert($postArray);
                $postMediaFile = array_chunk($postMediaFile , self::chunkSize);
                $postComment = array_chunk($postComment, self::chunkSize);
                $emojiOfPostArray = array_chunk($emojiOfPostArray, self::chunkSize);
                foreach ($postMediaFile as $mediaFile) {
                    IndividualMediaFile::query()->insert($mediaFile);
                }
                foreach ($postComment as $comment) {
                    IndividualComment::query()->insert($comment);
                }
                foreach ($emojiOfPostArray as $emoji) {
                    IndividualPostEmoji::query()->insert($emoji);
                }
                $postArray = [];
                $postMediaFile = [];
                $postComment = [];
                $emojiOfPostArray = [];
                $bar->advance();
            });
            $bar->finish();
        } catch (Throwable $th) {
            $bar->finish();
            $this->error($th);
        }
    }

    private function getArrayIndividualPost(string $userId): array
    {
        $timeFaker = fake()->dateTimeBetween(now()->subYear(), now());

        return [
            'id' => (new IndividualPost())->newUniqueId(),
            'title' => implode(" ", fake('vi_VN')->words(rand(4, 20))),
            'scope' => fake()->numberBetween(
                config('individual_posts.scope.public'), config('individual_posts.scope.only_friend')
            ),
            'enable_notification' => fake()->numberBetween(config('individual_posts.enable_notification.turn_on'),
                config('individual_posts.enable_notification.turn_off')),
            'scope_comment' => fake()->numberBetween(config('individual_posts.scope_comment.public'),
                config('individual_posts.scope_comment.only_friend')),
            'user_id' => $userId,
            'created_at' => $timeFaker,
            'updated_at' => $timeFaker,
        ];
    }

    private function getIndividualMediaFile(string $postId, string $userId): array
    {
        $timeFaker = fake()->dateTimeBetween(now()->subYear(), now())->format('Y-m-d H:i:s');

        return [
            'id' => (new IndividualMediaFile())->newUniqueId(),
            'path' => fake()->imageUrl(),
            'name' => fake()->firstName(),
            'type' => fake()->numberBetween(config('individual_posts.individual_media_files.type.media_files'),
                config('individual_posts.individual_media_files.type.video')),
            'individual_post_id' => $postId,
            'user_id' => $userId,
            'created_at' => $timeFaker,
            'updated_at' => $timeFaker,
        ];
    }

    private function getIndividualComment(string $postId, string $userId): array
    {
        $timeFaker = fake()->dateTimeBetween(now()->subYear(), now())->format('Y-m-d H:i:s');

        return [
            'id' => (new IndividualComment())->newUniqueId(),
            'content' => fake()->text(),
            'individual_post_id' => $postId,
            'user_id' => $userId,
            'created_at' => $timeFaker,
            'updated_at' => $timeFaker,
        ];
    }

    private function getIndividualEmoji(string $postId, string $userId): array
    {
        $timeFaker = fake()->dateTimeBetween(now()->subYear(), now())->format('Y-m-d H:i:s');

        return [
            'id' => (new IndividualPostEmoji())->newUniqueId(),
            'individual_post_id' => $postId,
            'emoji_id' => fake()->numberBetween(1, 7),
            'user_id' => $userId,
            'created_at' => $timeFaker,
            'updated_at' => $timeFaker,
        ];
    }
}
