<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\Sitesettings;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('logged_in_user', auth()->user());

        // imtiaz set global variable of site settings
            $siteSettings=array();
            $sitesettingsData = Sitesettings::select('fieldname','fieldvalue')->get();
            $sitesettingsData = reset($sitesettingsData);
            if(!empty($sitesettingsData))
            {
                foreach ($sitesettingsData as $moddata)
                {
                    $siteSettings[$moddata->fieldname]=$moddata->fieldvalue;
                }
            }

            $siteSettings = (object) $siteSettings;
            $view->with('site_settings', $siteSettings);
        // imtiaz set global variable of site settings        
    }
}
