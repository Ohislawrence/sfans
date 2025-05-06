<?php

use App\Http\Controllers\Admin\AffiliatelinkController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\SlutController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\FrontpageContrller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgeVerificationController;
use App\Http\Controllers\BotController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\ShortsController;
use Spatie\Permission\Models\Role;

Route::get('/age-verification', [AgeVerificationController::class, 'show'])->name('age.verify');
Route::post('/age-verification', [AgeVerificationController::class, 'verify'])->name('age.verify.submit');

//rotect your website pages
Route::middleware(['age.verified'])->group(function () {
    Route::get('/', [FrontpageContrller::class, 'index'])->name('home');
    //shorts
    Route::get('shorts', [FrontpageContrller::class, 'shortsview'])->name('short');
    Route::get('shorts/{slug}', [ShortsController::class, 'shortsviewsingle'])->name('short.single');
    Route::get('api/next-video', [ShortsController::class, 'getNextVideo']);
    Route::get('api/prev-video', [ShortsController::class, 'getPrevVideo']);
    Route::get('api/shorts', [FrontpageContrller::class, 'shorts']);
    
    //Route::get('short/{slug}', [FrontpageContrller::class, 'shortsview'])->name('short.view');
    //videos
    Route::get('videos', [FrontpageContrller::class, 'videos'])->name('videos');
    Route::get('video/{category}/{slug}', [FrontpageContrller::class, 'video'])->name('video.view');
    //category
    Route::get('categories', [FrontpageContrller::class, 'categories'])->name('categories');
    Route::get('category/{slug}/videos', [FrontpageContrller::class, 'videocategory'])->name('category.video');
    Route::get('category/{slug}/photos', [FrontpageContrller::class, 'photocategory'])->name('category.photos');
    Route::get('category/{slug}/gifs', [FrontpageContrller::class, 'gifcategory'])->name('category.gif');
    //tags
    Route::get('tags', [FrontpageContrller::class, 'tags'])->name('tags');
    Route::get('tags/videos/{slug}', [FrontpageContrller::class, 'videotag'])->name('tag.video');
    Route::get('tags/photos/{slug}', [FrontpageContrller::class, 'phototag'])->name('tag.photos');
    Route::get('tags/gifs/{slug}', [FrontpageContrller::class, 'giftags'])->name('tags.gif');
    //photos
    Route::get('photos', [FrontpageContrller::class, 'photos'])->name('photos');
    Route::get('photo/{slug}', [FrontpageContrller::class, 'photoview'])->name('photo.view');
    //gifs
    Route::get('gifs', [FrontpageContrller::class, 'gifs'])->name('gifs');
    Route::get('gif/{slug}', [FrontpageContrller::class, 'gifview'])->name('gifs.view');
    //userlist
    Route::get('pornstars', [FrontpageContrller::class, 'pornstars'])->name('pornstars');
    Route::get('sluts', [FrontpageContrller::class, 'sluts'])->name('sluts');
    //profile
    Route::get('profile/{username}/{tab?}', [FrontpageContrller::class, 'profile'])->name('profile');
    //Route::get('profile/{username}/shorts', [FrontpageContrller::class, 'profileshorts'])->name('profileshorts');
    //Route::get('profile/{username}/photos', [FrontpageContrller::class, 'profilephotos'])->name('profilephotos');
    //chat
    
});




Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //frontend chat
    //Route::get('chat/recieve/{botUserId}', [BotController::class, 'sendMessage'])->name('chat.recieve');
    Route::get('chat/{botUserId}', [BotController::class, 'index'])->name('chat');
    Route::get('chat/history/{botUserId}', [BotController::class, 'chatHistoty'])->name('chat.history');
    Route::post('/send/chat/{botUserId}', [ChatController::class, 'chat'])->name('chat.recieve');
    
    //admin
Route::prefix('admin')
->middleware(['web', 'role:admin'])
->as('admin.')
->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('affiliatelink', AffiliatelinkController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('photos', PhotoController::class);

    //sluts
    Route::get('just/slut', [SlutController::class, 'view'])->name('view.slut');

    //Route::post('/chat/{UserId}/train', [ChatController::class, 'trainFromTextFile'])->name('chat.train');
    Route::get('/bots/{username}/train', [ChatController::class, 'train'])->name('bots.train.form');
    Route::post('post/bots/{username}/train', [ChatController::class, 'create'])->name('bots.train.store');
    Route::post('post/bots/{username}/retrain', [ChatController::class, 'retrain'])->name('bots.retrain.store');
});


    //fan
    Route::group([
        'namespace' => 'App\Http\Controllers\Fan',
        'prefix' => 'fan',
        'middleware' => 'role:fan',
        'as' => 'fan.',
        
    ], function () {
        
    });
});

require __DIR__.'/auth.php';
