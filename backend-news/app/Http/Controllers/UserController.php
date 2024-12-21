<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SavePreferencesRequest;

class UserController extends BaseController
{
    /**
     * Save user preferences.
     */
    public function savePreferences(SavePreferencesRequest $request)
    {
        $user = Auth::user();
        $user->preferences = $request->validated();
        $user->save();

        return $this->sendSuccess($user->preferences, 'Preferences saved successfully.');
    }
}
