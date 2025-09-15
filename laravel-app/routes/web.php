<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolsPageController;

Route::get('/tools', [ToolsPageController::class, 'index'])->name('tools.index');