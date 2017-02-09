<?php
/**
 * creates a tag cloud from an array of terms
 *
 * Given a single dimensional array of terms, this class will output a piece of
 * HTML with each term wrapped in a span tag with an ID that you can define in
 * your CSS.
 *
 * Project page is :
 * http://www.calevans.com/view.php/page/tagcloud
 *
 * @author Cal Evans <cal@calevans.com>
 * @version 1.2
 * @copyright (c) 2006 Evans Internet Construction Company
 * @license GPL 2.0
 * @access public
 *
 * @todo: refactor. Make it work with an already weighted list. Passing huge
 * single dimminsion arrays isn't really feasible in most situations.
 */
class Cal_TagCloud {

    /**
     * Initial array handed into the consturctor
     * @var array
     */
    public $inputArray;

    /**
     * Final array built with weighted terms and _sorted. This is what the
     * final output string is built from.
     * @var array
     */
    public $outputArray;

    /**
     * The final output string.
     * @var string
     */
    public $outputCloud;

    /**
     * the number of _buckets. Usually 10. Make sure you have the proper number
     * of CSS tags defined. (ie.e if you say 12 _buckets make sure you have
     * tag_cloud_1 - tag_cloud_12 defined)
     * @var integer
     */
    protected $_buckets;

    /**
     * Intermediary array. This is in the form of word=>weight.
     * @var array
     */
    protected $_consolidatedArray;

    /**
     * The highest weight
     * @var integer
     */
    protected $_ceiling;

    /**
     * The CSS tag name prefix. i.e. tag_cloud_ would get you tag_cloud_1
     * @var string
     */
    protected $_cssPrefix;

    /**
     * the lowest weight
     * @var integer
     */
    protected $_floor;

    /**
     * URL to wrap around each phrase. a sing %s will be substutited for
     * the urlencoded phrase.
     * @var string
     */
    protected $_link;

    /**
     * The maximum number of tags in the cloud.
     * @var integer
     */
    protected $_maxTags;

    /**
     * show the score in a tooltip
     * @var boolean
     */
    protected $_showScore;

    /**
     * _sort to apply to the array. valid values are alpha and weight.
     * @var string
     */
    protected $_sort;

    /**
     * character(s) to place between span tags.
     * @var string
     */
    protected $_spacer;

    /**
    * constructor
    */
    public function __construct($inputArray = array(), $_link = '')
    {
        $this->inputArray        = $inputArray;
        $this->_consolidatedArray = array();
        $this->outputArray       = array();
        
        $this->_cssPrefix   = 'tagcloud_';
        $this->outputCloud = '';;
        $this->_buckets     = 10;
        $this->_sort        = 'alpha';
        $this->_maxTags     = 20;
        $this->_ceiling     = 1;
        $this->_floor       = 9999999;
        $this->_spacer      = '';
        $this->_showScore   = true;

        $this->setLink($_link);
    } // public function __construct($inputArray = array(), $_link = '') 


    /**
    * set the _cssPrefix
    *
    * @public
    * @param string $value the new value
    * @return object referrence to this
    */
    public function setCssPrefix($value)
    {
        if($value) $this->_cssPrefix = $value;
        return $this;
    } // public function setCssPrefix($value)

    /**
    * get the _cssPrefix
    *
    * @public
    * @return string the value stored in $this->_cssPrefix
    */
    public function getCssPrefix()
    {
        return $this->_cssPrefix;
    } // public function getCssPrefix()

    /**
    * set _showScore
    *
    * @public
    * @param string $value the new value
    * @return object referrence to this
    */
    public function setShowScore($value)
    {
        if ($value=="none" or $value=="weight" or $value=="score") {
            $this->_showScore = $value;
        }
        return $this;
    } // public function setShowScore($value)

    /**
    * get the show Score
    *
    * @public
    * @return boolean the value stored in $this->_showScore
    */
    public function getShowScore()
    {
        return $this->_showScore;
    } // public function getShowScore()


    /**
    * set the _link value
    *
    * @public
    * @param string $value the new value
    * @return object referrence to this
    */
    public function setLink($value)
    {
        if($value) $this->_link = $value;
        return $this;
    } // public function setLink($value)

    /**
    * get the _link value
    *
    * @public
    * @return string the value stored in $this->_link
    */
    public function getLink()
    {
        return $this->_link;
    } // public function getLink()


    /**
    * set the _buckets value
    *
    * @public
    * @param integer $value the new value
    * @return object referrence to this
    */
    public function setBuckets($value)
    {
        if($value) $this->_buckets = intval($value);
        return $this;
    } // public function setBuckets($value)

    /**
    * get the _buckets value
    *
    * @public
    * @return integer value stored in $this->_buckets
    */
    public function getBuckets()
    {
        return intval($this->_buckets);
    } // public function getBuckets()


    /**
    * set the _sort order
    *
    * @public
    * @param string $value the new value
    * @return object referrence to this
    */
    public function setSort($value)
    {
        if($value) $this->_sort = $value;
        return $this;
    } // public function setSort($value)

    /**
    * get the _sort order
    *
    * @public
    * @string the _sort order to use.
    */
    public function getSort()
    {
        return $this->_sort;
    } // public function getSort()


    /**
    * set the _maxTags
    *
    * @public
    * @param integer $value the new value
    * @return object referrence to this
    */
    public function setMaxTags($value)
    {
        $this->_maxTags = intval($value);
        return $this;
    } // public function setMaxTags($value)

    /**
    * set the _maxTags
    *
    * @public
    * @preturn integer the value stored in $this->_maxTags
    */
    public function getMaxTags()
    {
        return intval($this->_maxTags);
    } // public function getMaxTags()


    /**
    * set the _spacer
    *
    * @public
    * @param string $value the new value
    * @return object referrence to this
    */
    public function setSpacer($value)
    {
        if($value) $this->_spacer = $value;
        return $this;
    } // public function setSpacer($value)

    /**
    * get the _spacer
    *
    * @public
    * @return string the value stored in $this->_spacer.
    */
    public function getSpacer()
    {
        return $this->_spacer;
    } // public function getSpacer()


    /**
    * builds the tag cloud.
    *
    * This calls all the other methods. All the work is encapsulated in the
    * methods so that any single piece can be overridden without haivng to
    * overwrite everything.
    *
    * @public
    * @return bool true...always true
    */
    public function buildCloud()
    {
        $this->consolidateArray()
             ->filterArray()
             ->computeBounds()
             ->sortArray()
             ->computeWeights()
             ->buildOutput();
        return true;
    } // public function get_cloud()


    /**
    * build the consolidated array.
    *
    * This takes the input array and builds the consolidated array.
    *
    * @protected
    * @return object referrence to this
    */
    protected function consolidateArray()
    {
        $this->_consolidatedArray = array_count_values($this->inputArray);
        return $this;
    } // protected function consolidateArray()


    /**
    * Trim the bottom of the stack.
    * @protected
    * @return object referrence to this
    */
    protected function filterArray()
    {
        arsort($this->_consolidatedArray);
        $this->_consolidatedArray = array_slice($this->_consolidatedArray,
                                                0,
                                                $this->_maxTags);
        return $this;
    } // protected function filterArray()


    /**
    * computer the high and low score from the consolidated array.
    *
    * @protected
    * @return object referrence to this
    */
    protected function computeBounds()
    {
        foreach ($this->_consolidatedArray as $word=>$weight) {
            $this->_ceiling = max($weight, $this->_ceiling);
            $this->_floor   = min($weight, $this->_floor);
        } // foreach ($work_array as $word=>$weight)
        return $this;
    } // protected function computeBounds()


    /**
    * _sort the array by the requested _sort order.
    *
    * @protected
    * @return object referrence to this
    */
    protected function sortArray()
    {
        if ($this->_sort=='weight') {
            arsort($this->_consolidatedArray);
        } else if ($this->_sort=='alpha') {
            ksort($this->_consolidatedArray);
        } // if ($_sort=='alpha')
        return $this;
    } // protected function sortArray()


    /**
    * compute the weights and build the output
    *
    * converts scores into weights and the build the output string
    *
    * @protected
    * @return object referrence to this
    */
    protected function computeWeights()
    {
        $difference = ($this->_ceiling-$this->_floor);
        $increment = $difference/($this->_buckets-1);
        $this->outputArray = array();
        foreach ($this->_consolidatedArray as $word=>$weight) {
            $this->outputArray[$word] = array('score' => round(($weight-$this->_floor)/$increment)+1,
                                             'weight' => $weight);
        } // foreach ($work_array as $word=>$weight)
        return $this;
    } // protected function computeWeights()


    /**
    * build the final output
    *
    * converts the output array into html. Normally I'd break this out into a
    * decorator class but this is such a simple task that it didn't seem worth
    * the effort. However, if you are reading this then feel free to do so. You
    * can also just override this method to do your own thing here.
    *
    * @protected
    * @return object referrence to this
    */
    protected function buildOutput()
    {
        $this->outputCloud = '';
        foreach ($this->outputArray as $word=>$wordArray) {
            
            if (!empty($this->_link)) {
                $this->outputCloud .= '<a href="javascript:void(0);" onclick="' . sprintf($this->_link, urlencode($word)).'">';
            } // if (!empty($this->_link))
            
            $this->outputCloud .= '<span id="' . $this->_cssPrefix.$wordArray['score'].'"';
            
            if ($this->_showScore!="none") {
                $this->outputCloud .= 'title="- ' . $wordArray[$this->_showScore].' -" ';
            } // if ($this->get_showScore()!="none") 
            
            $this->outputCloud .= '>'.$word.'</span>';
            
            if (!empty($this->_link)) {
                $this->outputCloud.= '</a>';
            } // if (!empty($this->_link))
            
            $this->outputCloud .= $this->_spacer;
        } // foreach ($work_array as $word=>$weight)
        return $this;
    } // protected function buildOutput($_spacer, $_cssPrefix, $_link )

} // class Cal_TagCloud

?>