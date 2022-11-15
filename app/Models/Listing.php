<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{

    const titleColumnName = "title";
    const descriptionColumnName = "description";
    const companyColumnName = "company";
    const locationColumnName = "location";
    const websiteColumnName = "website";
    const emailColumnName = "email";
    const tagsColumnName = "tags";
    const userIDColumnName = "tags";

    use HasFactory;

    // protected $fillable = array( "title", "company", "location", "website", "email", "description", "tags" );

    public function scopeFilter($query, array $filters)
    {
        if($filters["tags"] ?? false) {
            $query->where(self::tagsColumnName, "like", "%".request('tag')."%");
        }
        
        if($filters["search"] ?? false) {
            $query
                ->where(self::titleColumnName, "like", "%".request('search')."%")
                ->orWhere(self::descriptionColumnName, "like", "%".request('search')."%")
                ->orWhere(self::tagsColumnName, "like", "%".request('search')."%");
        }
    }

    public function user() {
        return $this->belongsTo(User::class, self::userIDColumnName);
    }

}
