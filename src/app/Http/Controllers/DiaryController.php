<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Diary;

class DiaryController extends Controller
{
    public function index()
    {
        $diaries = Diary::latest()->paginate(5);
        return view('index',compact('diaries'));
    }

    public function create()
    {
        return view('create');
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ], [
            // テキスト
            'body.required' => '日記を入力してください',
            'body.max' => '日記は20文字以内で入力してください',
            // 画像系
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => 'jpg / jpeg / png / gif / webp形式の画像をアップロードしてください',
            'image.max'   => '画像サイズは2MB以内にしてください',
        ]);

        $image_path = null;

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('tmp', 'public');
        }

        return view('confirm', [
            'image_path' => $image_path,
            'body' => $validated['body']
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'body' => 'required|max:20'
        ]);

        $image_path = null;

        if ($request->image_path) {
            $newPath = 'images/' . basename($request->image_path);
            Storage::disk('public')->move($request->image_path, $newPath);

            $image_path = $newPath;
        }

        Diary::create([
            'image_path' => $image_path,
            'body' => $request->body
        ]);

        return redirect('/');
    }

    public function edit(Diary $diary)
    {
        return view('edit',compact('diary'));
    }

    public function confirmUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ], [
            // テキスト
            'body.required' => '日記を入力してください',
            'body.max' => '日記は20文字以内で入力してください',
            // 画像系
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => 'jpg / jpeg / png / gif / webp形式の画像をアップロードしてください',
            'image.max'   => '画像サイズは2MB以内にしてください',
        ]);

        $image_path = null;

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('tmp', 'public');
        }

        return view('confirm', [
            'image_path' => $image_path,
            'body' => $validated['body'],
            'diary_id' => $id,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $diary = Diary::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg|max:2048',
            'body' => 'required|string|max:20'
        ]);

        $image_path = null;

        if ($request->image_path) {
            $newPath = 'images/' . basename($request->image_path);
            Storage::disk('public')->move($request->image_path, $newPath);

            $image_path = $newPath;
        }

        $diary->body = $request->body;
        $diary->image_path = $image_path;
        $diary->save();

        return redirect('/');
    }

    public function destroy(Diary $diary)
    {
        $diary->delete();
        return redirect('/');
    }
}