<?php namespace Kareem3d\Images;

use \Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Kareem3d\Eloquent\Algorithm;

class VersionAlgorithm extends Algorithm {

    /**
     * @param Image $image
     * @return $this
     */
    public function byImage( Image $image )
    {
        $this->getQuery()->where('image_id', $image->id);

        return $this;
    }

    /**
     * @param  int $width
     * @param  int $height
     * @param bool $lowerSize
     * @return $this
     */
    public function nearestDim( $width, $height, $lowerSize = false )
    {
        if(! $lowerSize)
        {
            $this->getQuery()->where('width' , '>=', $width);
            $this->getQuery()->where('height', '>=', $height);
        }

        if($width)  $this->getQuery()->orderBy(DB::raw('ABS(width - ' .$width. ')'), 'ASC');
        if($height) $this->getQuery()->orderBy(DB::raw('ABS(height - '.$height.')'), 'ASC');

        return $this;
    }

    /**
     * @return $this
     */
    public function smallestDim()
    {
        $this->getQuery()->orderBy('width', 'ASC')->orderBy('height', 'ASC');

        return $this;
    }

    /**
     * @return $this
     */
    public function largestDim()
    {
        $this->getQuery()->orderBy('width', 'DESC')->orderBy('height', 'DESC');

        return $this;
    }

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return Version::query();
    }
}