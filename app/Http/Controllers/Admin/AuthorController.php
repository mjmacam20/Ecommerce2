<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Session;

class AuthorController extends Controller
{
    public function authors(){
        Session::put('page','authors');
        $authors = Author::get()->toArray();

        return view('admin.authors.authors')->with(compact('authors'));
    }
    public function updateAuthorStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            
            /*echo"<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Author::where('id',$data['author_id'])->update(['status'=>$status]);
            return response()->json(['status'=> $status,'author_id'=>$data['author_id']]);
        }
    }
    public function deleteAuthor($id){
        Author::where('id',$id)->delete();
        $message = "Author has been deleted successfully!";
        return redirect()->back()->with("success_message", $message);

    }
    public function addEditAuthor(Request $request,$id=null){
        Session::put('page','authors');
        if($id==""){
            $title = "Add Author";
            $author = new Author;
            $message = "Author added successfully!";
        }else{
            $title = "Add Author";
            $author = Author::find($id);
            $message = "Author updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'author_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessages = [
                'author_name.required' => 'Author Name is required',
                'author_name.regex' => 'Valid Author Name is required',
            ];

            $this->validate($request,$rules,$customMessages);

            $author->name = $data['author_name'];
            $author->status = 1;
            $author->save();

            return redirect('admin/authors')->with('success_message',$message);
        }
        return view('admin.authors.add_edit_author')->with(compact('title','author'));
    }
}
