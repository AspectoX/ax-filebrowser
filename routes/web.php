<?php

use Illuminate\Support\Facades\Route;
use AspectoX\AxFileBrowser\AxFileBrowserController;

Route::prefix('ax-filebrowser')->middleware('web')->group(function () {
 
    // Vista principal
    Route::get('/', [AxFileBrowserController::class, 'index'])->name('ax.index');
 
    // Carpetas
    Route::get('/folder/create', [AxFileBrowserController::class, 'folderCreate'])->name('ax.folder.create');
    Route::post('/folder/store', [AxFileBrowserController::class, 'folderStore'])->name('ax.folder.store');
    Route::post('/folder/rename', [AxFileBrowserController::class, 'folderRename'])->name('ax.folder.rename');
    Route::post('/folder/delete', [AxFileBrowserController::class, 'folderDelete'])->name('ax.folder.delete');
 
    // Rename / Move / Copy
    Route::post('/rename', [AxFileBrowserController::class, 'rename'])->name('ax.rename');
    Route::post('/move',   [AxFileBrowserController::class, 'move'])->name('ax.move');
    Route::post('/copy',   [AxFileBrowserController::class, 'copy'])->name('ax.copy');
 
    // Metadata fetch/save
    Route::get('/metadata-fetch',  [AxFileBrowserController::class, 'metadataFetch'])->name('ax.metadata.fetch');
    Route::post('/metadata-fetch', [AxFileBrowserController::class, 'metadataSave'])->name('ax.metadata.save');
 
    // Archivos
    Route::post('/upload', [AxFileBrowserController::class, 'upload'])->name('ax.upload');
    Route::post('/upload-gallery', [AxFileBrowserController::class, 'uploadGallery'])->name('ax.upload.gallery');
    Route::post('/delete/{id}', [AxFileBrowserController::class, 'fileDelete'])->name('ax.file.delete');
    Route::post('/delete-by-path', [AxFileBrowserController::class, 'fileDeleteByPath'])->name('ax.file.delete.path');

    // Buscador
    Route::get('/search', [AxFileBrowserController::class, 'search'])->name('ax.search');
 
    // Disk usage
    Route::get('/disk-usage', [AxFileBrowserController::class, 'diskUsage'])->name('ax.disk.usage');
 
    // Guardar imagen editada
    Route::post('/image/save', [AxFileBrowserController::class, 'imageSave'])->name('ax.image.save');
 
    // Picker
    Route::get('/picker', [AxFileBrowserController::class, 'picker'])->name('ax.picker');
});