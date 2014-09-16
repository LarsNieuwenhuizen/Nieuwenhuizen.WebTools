<?php
namespace Nieuwenhuizen\WebTools\ViewHelpers;

use TYPO3\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class TypeOfViewHelper extends AbstractConditionViewHelper {

	/**
	 * @param mixed $variable
	 * @param array $type
	 * @return string
	 */
	public function render($variable = NULL, $type = array('array')) {
		if ($variable === NULL) {
			$variable = $this->renderChildren();
		}
		if (in_array(gettype($variable), $type) === TRUE) {
			return $this->renderThenChild();
		}
		return $this->renderElseChild();
	}

}