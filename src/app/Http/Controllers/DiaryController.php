<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $request->validate([
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

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        Diary::create([
            'body' => $request->body,
            'image_path' => $path
        ]);

        return redirect('/');
    }

    public function edit(Diary $diary)
    {
        return view('edit',compact('diary'));
    }

    public function update(Request $request, Diary $diary)
    {
        $request->validate([
            'body' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $diary->image_path = $path;
        }

        $diary->body = $request->body;
        $diary->save();

        return redirect('/');
    }

    public function destroy(Diary $diary)
    {
        $diary->delete();
        return redirect('/');
    }
}