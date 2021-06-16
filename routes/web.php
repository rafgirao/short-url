<?php

Route::get('/short/{shortURLKey}', 'RafaelGirao\ShortURL\Controllers\ShortURLController')->name('short-url.invoke');
