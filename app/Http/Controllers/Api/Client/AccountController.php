<?php

namespace Pterodactyl\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use Pterodactyl\Models\User;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Pterodactyl\Facades\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Pterodactyl\Notifications\VerifyEmail;
use Pterodactyl\Services\Users\UserUpdateService;
use Pterodactyl\Transformers\Api\Client\AccountTransformer;
use Pterodactyl\Http\Requests\Api\Client\Account\UpdateEmailRequest;
use Pterodactyl\Http\Requests\Api\Client\Account\UpdatePasswordRequest;
use Pterodactyl\Http\Requests\Api\Client\Account\UpdateUsernameRequest;

class AccountController extends ClientApiController
{
    /**
     * AccountController constructor.
     */
    public function __construct(private AuthManager $manager, private UserUpdateService $updateService)
    {
        parent::__construct();
    }

    public function index(Request $request): array
    {
        return $this->fractal->item($request->user())
            ->transformWith($this->getTransformer(AccountTransformer::class))
            ->toArray();
    }

    /**
     * Update the authenticated user's email address.
     */
    public function updateEmail(UpdateEmailRequest $request): JsonResponse
    {
        $original = $request->user()->email;
        $this->updateService->handle($request->user(), $request->validated());

        if ($original !== $request->input('email')) {
            Activity::event('user:account.email-changed')
                ->property(['old' => $original, 'new' => $request->input('email')])
                ->log();
        }

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Update the authenticated user's password. All existing sessions will be logged
     * out immediately.
     *
     * @throws \Throwable
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $user = $this->updateService->handle($request->user(), $request->validated());

        $guard = $this->manager->guard();
        // If you do not update the user in the session you'll end up working with a
        // cached copy of the user that does not include the updated password. Do this
        // to correctly store the new user details in the guard and allow the logout
        // other devices functionality to work.
        $guard->setUser($user);

        // This method doesn't exist in the stateless Sanctum world.
        if (method_exists($guard, 'logoutOtherDevices')) {
            $guard->logoutOtherDevices($request->input('password'));
        }

        Activity::event('user:account.password-changed')->log();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Update the authenticated user's username.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function updateUsername(UpdateUsernameRequest $request): JsonResponse
    {
        $original = $request->user()->username;

        $this->updateService->handle($request->user(), $request->validated());

        Activity::event('user:account.username-changed')
            ->property(['old' => $original, 'new' => $request->input('username')])
            ->log();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    public function discord(): JsonResponse
    {
        return new JsonResponse([
            'https://discord.com/api/oauth2/authorize?'
            . 'client_id=' . $this->settings->get('jexactyl::discord:id')
            . '&redirect_uri=' . route('api:client.account.discord.callback')
            . '&response_type=code&scope=identify%20email%20guilds%20guilds.join&prompt=none',
        ], 200, [], null, false);
    }

    public function discordCallback(Request $request): RedirectResponse
    {
        $code = Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id' => $this->settings->get('jexactyl::discord:id'),
            'client_secret' => $this->settings->get('jexactyl::discord:secret'),
            'grant_type' => 'authorization_code',
            'code' => $request->input('code'),
            'redirect_uri' => route('api:client.account.discord.callback'),
        ]);

        if (!$code->ok()) {
            return redirect('/account');
        }

        $req = json_decode($code->body());
        if (preg_match('(email|identify)', $req->scope) !== 1) {
            return redirect('/account');
        }

        $discord = json_decode(Http::withHeaders(['Authorization' => 'Bearer ' . $req->access_token])->asForm()->get('https://discord.com/api/users/@me')->body());

        User::query()->where('id', '=', Auth::user()->id)->update(['discord_id' => $discord->id]);

        return redirect('/account');
    }

    public function verify(Request $request): JsonResponse
    {
        $token = $this->genStr();
        $name = $this->settings->get('settings::app:name', 'Jexactyl');
        DB::table('verification_tokens')->insert(['user' => $request->user()->id, 'token' => $token]);
        $request->user()->notify(new VerifyEmail($request->user(), $name, $token));

        return new JsonResponse(['success' => true, 'data' => []]);
    }

    private function genStr(): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $pieces = [];
        $max = mb_strlen($chars, '8bit') - 1;
        for ($i = 0; $i < 32; ++$i) {
            $pieces[] = $chars[mt_rand(0, $max)];
        }

        return implode('', $pieces);
    }
}
