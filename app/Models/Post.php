<?php
// app/Models/Post.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;  // Correct import statement

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'author_id', 'tag_id', 'title', 'slug', 'content', 'excerpt', 'thumbnail', 'is_published', 'published_at', 'visits'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
}
