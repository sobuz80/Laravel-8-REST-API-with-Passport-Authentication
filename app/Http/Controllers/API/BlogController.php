<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Blog;
use Validator;
use App\Http\Resources\Blog as BlogResource;
   
class BlogController extends BaseController
{
  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Blogs = Blog::all();
        return $this->sendResponse(BlogResource::collection($Blogs), 'Blogs retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $Blog = Blog::create($input);
   
        return $this->sendResponse(new BlogResource($Blog), 'Blog created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        
        $Blog = Blog::find($id);
  
        if (is_null($Blog)) {
            return $this->sendError('Blog not found.');
        }
   
        return $this->sendResponse(new BlogResource($Blog), 'Blog retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $Blog)
    {
        

        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $Blog->title = $input['title'];
        $Blog->description = $input['description'];
        $Blog->save();
   
        return $this->sendResponse(new BlogResource($Blog), 'Blog updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $Blog)
    {
        $Blog->delete();
   
        return $this->sendResponse([], 'Blog deleted successfully.');
    }
}