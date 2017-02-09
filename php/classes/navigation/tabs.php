<?php 

class Content
{
	function getPage($id, $activeId)
	{
		if (($id < 1) || ($id > 4)) {

			return null;
		}

		if (($activeId >= 1) && ($activeId <= 4)) {

			$activeTab =& XOAD_HTML::getElementById('page-' . $activeId);

			$activeTab->className = '';
		}

		$pageTab =& XOAD_HTML::getElementById('page-' . $id);

		$pageTab->className = 'active';

		$page = @join(null, @file(XOAD_BASE . 'inc/page' . $id . '.html'));

		$content =& XOAD_HTML::getElementById('content');

		$content->innerHTML = $page;

		return true;
	}

	function xoadGetMeta()
	{
		XOAD_Client::mapMethods($this, array('getPage'));
	}
}

?>