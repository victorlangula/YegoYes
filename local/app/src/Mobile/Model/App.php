<?php
namespace Mobile\Model;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;
use Eloquent, DB;

Class App extends Eloquent implements StaplerableInterface
{
	use SoftDeletingTrait;
    use EloquentTrait;

    protected $table = 'apps';

    /**
     * Laravel-Stapler
     */

    protected $fillable = ['header', 'background_smarthpones'];

    public function __construct(array $attributes = array(), $exists = false) {

        // Is used for custom icon and header icon for future use
        $this->hasAttachedFile('header', [
            'styles' => [
                'icon1024' => '1024x1024#',
                'icon152' => '152x152#',
                'icon140' => '140x140#',
                'icon120' => '120x120#',
                'icon80' => '80x80#',
                'icon76' => '76x76#',
                'icon70' => '70x70#',
                'icon40' => '40x40#',
                'icon21' => '21x21#'
            ]
        ]);
        $this->hasAttachedFile('background_smarthpones', [
            'styles' => [
                'bg' => '640x1136#'
            ]
        ]);

        parent::__construct($attributes, $exists);

        //parent::boot();

        static::creating(function($item)
        {
			$item->created_by = \Auth::user()->id;
			$item->updated_by = \Auth::user()->id;
            \App\Controller\LogController::Log(\Auth::user(), trans('global.' . $item->appType->name), 'created app (' . $item->name . ')', 'app');
        });

        static::updating(function($item)
        {
			/*
			$item->updated_by = \Auth::user()->id;
            \App\Controller\LogController::Log(\Auth::user(), trans('global.' . $item->appType->name), 'updated app (' . $item->name . ')', 'app');
			*/
        });
    }

	/**
	 * Soft delete
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	public function scopeDomain($query)
	{
		return (trim($this->domain) != '') ? 'http://' . $this->domain : url('/mobile/' . $this->local_domain);
	}

	public function scopeIcon($query, $size = 70, $default = false)
	{
        if ($this->header_file_name != '' && ! $default)
        {
            return $this->header->url('icon' . $size);
        }
        elseif (trim($this->icon) != '')
        {
            return url('/static/app-icons/' . $this->icon . '/' . $size . '.png');
        }
        else
        {
            return url('/static/app-icons/' . $this->appType->app_icon . '/' . $size . '.png');
        }
        
		//return (trim($this->icon) != '') ? $this->icon : $this->appType->app_icon;
	}

	public function scopeTheme($query)
	{
		return (trim($this->theme) != '') ? $this->theme : $this->appType->name;
	}

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function campaign()
    {
        return $this->belongsTo('Campaign\Model\Campaign');
    }

    public function appPages()
    {
        return $this->hasMany('Mobile\Model\AppPage')->orderBy('lft');
    }

    public function appType()
    {
        return $this->belongsTo('Mobile\Model\AppType')->orderBy('sort');
    }
}