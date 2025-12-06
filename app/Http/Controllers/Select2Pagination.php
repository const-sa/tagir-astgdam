<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Pagination extends Controller
{

//    public function employees()
// {
//     $search = trim(request('search'));

//     $posts = DB::table('users')
//         ->select('id', DB::raw('name AS text'))
//         ->when($search, function ($query) use ($search) {
//             $normalizedSearch = $this->normalizeArabicText($search);
//             $searchWithoutDiacritics = $this->removeDiacritics($normalizedSearch);
//             $regexPattern = $this->getArabicRegex($normalizedSearch);

//             $query->where(function ($q) use ($normalizedSearch, $searchWithoutDiacritics, $regexPattern) {
//                 $q->where('name', 'LIKE', '%' . $normalizedSearch . '%')
//                     ->orWhere(
//                         DB::raw('REPLACE(REPLACE(REPLACE(REPLACE( name, "إ", "ا"), "أ", "ا"), "آ", "ا"), "ى", "ي")'),
//                         'LIKE',
//                         '%' . $searchWithoutDiacritics . '%'
//                     )
//                     ->orWhere('name', 'REGEXP', $regexPattern);
//             });
//         })
//         ->simplePaginate(10);

//     return response()->json([
//         'results' => $posts->items(),
//         'pagination' => [
//             'more' => !empty($posts->nextPageUrl()),
//         ],
//     ]);
// }
public function employees()
    {
        $search = trim(request('search'));

        $query = User::employes()
            ->select('id', DB::raw('name AS text'));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('phone', 'LIKE', '%' . $search . '%');
            });
        }

        $employees = $query->simplePaginate(10);

        return response()->json([
            'results' => $employees->items(),
            'pagination' => [
                'more' => !empty($employees->nextPageUrl()),
            ],
        ]);
    }
    public function nationalities()
    {
        if (\request()->ajax()) {
            $search = trim(\request('search'));
            $nationalities = DB::table('nationalities')
                ->select('id', DB::raw("CONCAT(name_ar, ' | ', name_en) AS text"))
                ->where('name_ar', 'LIKE', '%' . $search . '%')
                ->orWhere('name_en', 'LIKE', '%' . $search . '%')
                ->simplePaginate(10);
            $morePages = true;
            $pagination_obj = json_encode($nationalities);
            if (empty($nationalities->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $nationalities->items(),
                "pagination" => array(
                    "more" => $morePages
                )
            );
            return \Response::json($results);
        }
    }
}
