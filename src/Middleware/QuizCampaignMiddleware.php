<?php

namespace App\Middleware;

use Closure;
use App\Domain\Quiz\Model\QuizCampaign;

class QuizCampaignMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset(\Route::current()->parameters()['quizCampaignSlug'])){
                    
          $quizCampaignSlug = \Route::current()->parameters()['quizCampaignSlug'];

          try {
            $tenant = QuizCampaign::whereSlug($quizCampaignSlug)->firstOrFail();
            
            $request->session()->put('quizCampaign', $tenant);
            
          } catch (\Exception $e) {
            
            return redirect('/app')->withErrors($e->getMessage());
            //return back()->withError('Restaurante não Existe');
          }
          
        }else{
        
          return back()->withError('Especifique a Campanha na Url. ex: app/campanha/slug-da-campanha');
        }

        return $next($request);
    }
}