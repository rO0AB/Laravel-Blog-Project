<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Mail;

//models
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Config;

class Homepage extends Controller
{
    public function __construct()
    {
        if (Config::find(1)->active == 0) {
            return redirect()->to('site-bakimda')->send();
        }

        view()->share('pages', Page::where('status', 1)->orderBy('order', 'ASC')->get());
        view()->share('categories', Category::where('status', 1)->inRandomOrder()->get());
        view()->share('config', Config::find(1));
    }

    public function index()
    {
        $data['articles'] = Article::with('getCategory')->where('status', 1)->whereHas('getCategory', function ($query) {
            $query->where('status', 1);
        })->orderBy('created_at', 'DESC')->paginate(10);
        return view('front.homepage', $data);
    }

    public function single($category, $slug)
    {
        $category = Category::whereSlug($category)->first() ?? abort(403, 'Category has not been found');
        $article = Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403, 'Article has not been found');
        $article->increment('hit'); //do it with IP based method
        $data['article'] = $article;
        return view('front.single', $data);
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->first() ?? abort(403, 'Category has not been found');
        $data['category'] = $category;
        $data['articles'] = Article::where('category_id', $category->id)->where('status', 1)->orderBy('created_at', 'DESC')->paginate(1);
        return view('front.category', $data);
    }

    public function page($slug)
    {
        $page = Page::whereSlug($slug)->first() ?? abort(403, 'Page has not been found');
        $data['page'] = $page;
        return view('front.page', $data);
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function contactPost(Request $request)
    {

        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:10'
        ];

        $validate = Validator::make($request->post(), $rules);

        if ($validate->fails()) {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }

        Mail::send([], [], function ($message) use ($request) {
            $message->from('iletisim@blogsitesi.com', 'Blog sitesi');
            $message->to('furkangurel@hotmail.com');
            $message->setBody('Mesajı Gönderen: ' . $request->name . '</br />
                   Mesajı Gönderen Mail: ' . $request->email . '<br />
                   Mesajı Konusu: ' . $request->topic . '<br />
                   Mesaj: ' . $request->message . '<br /><br />
                   Mesaj Gönderilme Tarihi: ' . now() . '', 'text/html');
            $message->subject($request->name . 'iletisimden mesaj gonderildi');
        });
//        $contact = new Contact;
//        $contact->name = $request->name;
//        $contact->email = $request->email;
//        $contact->topic = $request->topic;
//        $contact->message = $request->message;
//        $contact->save();
        return redirect()->route('contact')->with('success', 'Message has been submitted');
    }
}
