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
use App\Http\Controllers\Admin\CsvController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\ShortsController;
use App\Http\Controllers\SocialiteController;
use Spatie\Permission\Models\Role;

Route::get('/age-verification', [AgeVerificationController::class, 'show'])->name('age.verify');
Route::post('/age-verification', [AgeVerificationController::class, 'verify'])->name('age.verify.submit');

//rotect your website pages
Route::middleware(['age.verified'])->group(function () {
    Route::get('/', [FrontpageContrller::class, 'index'])->name('home');
    //shorts
   // Route::get('shorts', [FrontpageContrller::class, 'shortsview'])->name('short');
    //Route::get('shorts/{slug}', [ShortsController::class, 'shortsviewsingle'])->name('short.single');
    //Route::get('api/next-video', [ShortsController::class, 'getNextVideo']);
    //Route::get('api/prev-video', [ShortsController::class, 'getPrevVideo']);
    //Route::get('api/shorts', [FrontpageContrller::class, 'shorts']);
    //Route::get('short/{slug}', [FrontpageContrller::class, 'shortsview'])->name('short.view');
    //videos
    Route::get('videos', [FrontpageContrller::class, 'videos'])->name('videos');
    Route::get('video/{category}/{slug}', [FrontpageContrller::class, 'video'])->name('video.view');
    //category
    Route::get('categories', [FrontpageContrller::class, 'categories'])->name('categories');
    Route::get('category/{slug}/{tab?}', [FrontpageContrller::class, 'category'])->name('category.all');
    Route::get('category/photos/{slug}', [FrontpageContrller::class, 'photocategory'])->name('category.photos');
    Route::get('category/gifs/{slug}', [FrontpageContrller::class, 'gifcategory'])->name('category.gif');
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
    //shop
    Route::get('shop', [FrontpageContrller::class, 'shop'])->name('shop');
    Route::get('products/{id}', [FrontpageContrller::class, 'show'])->name('products.show');
    //profile
    Route::get('profile/{username}/{tab?}', [FrontpageContrller::class, 'profile'])->name('profile');
    //Route::get('profile/{username}/shorts', [FrontpageContrller::class, 'profileshorts'])->name('profileshorts');
    //Route::get('profile/{username}/photos', [FrontpageContrller::class, 'profilephotos'])->name('profilephotos');
    //notify
    Route::get('notify', [FrontpageContrller::class, 'notify'])->name('notify');

    Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');
    
});




Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('dashboard', function () { return view('dashboard');})->name('dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    //frontend chat
    Route::get('chats', [BotController::class, 'allMessages'])->name('chat.all');
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
    Route::resource('media', VideoController::class);
    Route::resource('photos', PhotoController::class);
    Route::resource('shop', ShopController::class);

    //CVS import for media
    ROute::post('post-cvs-file', [CsvController::class, 'importVideosFromCSV'])->name('cvsimport');

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
