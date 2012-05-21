<?php
class HTMLBuilder {
	public static $charset = "UTF-8";
	public static $self_closing_tags = array(
		'link',
		'meta',
		'br',
		'hr',
		'img',
		'input',
		'param'
	);

	protected $_html;
	protected $_opened_tags;
	protected $_keep_opened;

	public static function dispatch() {
		return new static;
	}

	public function __construct() {
		$this->_opened_tags = array();

		$this
			->keep_opened(false)
			->flush();
	}

	public function __call($tag, $args) {
		$atts = isset($args[1]) ? $args[1] : array();
		$content = isset($args[0]) ? $args[0] : '';

		if(is_array($content)) list($content, $atts) = array('', $content);

		return $this->tag($tag, $content, $atts);
	}

	public function __toString() {
		return $this->to_string();
	}

	public function to_string($close_opened = true) {
		if($close_opened) while($this->has_opened_tags()) $this->close();

		return implode('', $this->_html);
	}

	public function open($tag = null, $atts = array(), $self_closing = null) {
		$this->keep_opened(true);

		if(isset($tag)) {
			if(!is_array($atts)) list($atts, $self_closing) = array(array(), (bool) $atts);
			if(!isset($self_closing)) $self_closing = $this->is_self_closing($tag);

			return $this->tag($tag, $self_closing, $atts);
		}

		return $this;
	}

	public function close() {
		return $this->has_opened_tags() ? $this->close_tag($this->pop_opened_tag()) : $this;
	}

	public function open_tag($tag, $atts = array(), $self_closing = null) {
		if(!is_array($atts)) list($atts, $self_closing) = array(array(), $atts);
		if(isset($self_closing)) $self_closing = (bool) $self_closing;

		if(!isset($self_closing)) $self_closing = $this->is_self_closing($tag);
		
		$atts = $this->array_to_attributes($atts);
		$end = $self_closing ? ' />' : '>';

		return $this->append_html("<{$tag}{$atts}{$end}");
	}

	public function close_tag($tag) {
		return $this->append_html("</{$tag}>");
	}

	public function tag($tag, $content = '', $atts = array()) {
		if(is_array($content)) list($content, $atts) = array('', $content);
		if(is_bool($content)) list($self_closing, $content) = array((bool) $content, '');
		else $self_closing = $this->is_self_closing($tag);

		$content = (string) $content;

		$this->open_tag($tag, $atts, $self_closing);
		if(!$self_closing and '' !== $content) $this->append_html($content);

		if($this->keep_opened()) {
			if(!$self_closing) $this->push_opened_tag($tag);

			return $this->keep_opened(false);
		}
		elseif(!$self_closing) return $this->close_tag($tag);
		else return $this;
	}

	public function text($content) {
		return $this->append_html($content);
	}

	public function append_html($html) {
		$this->_html[] = $html;

		return $this;
	}

	public function push_opened_tag($tag) {
		$this->_opened_tags[] = $tag;

		return $this;
	}

	public function pop_opened_tag() {
		return array_pop($this->_opened_tags);
	}

	public function flush() {
		$this->_html = array();

		return $this;
	}

	public function escape($str) {
		return htmlspecialchars($str, ENT_QUOTES, static::$charset);
	}

	public function array_to_attributes($atts = array()) {
		$string_atts = array();

		foreach($atts as $attribute_name => $attribute_value) {
			if(!isset($attribute_value)) continue;

			if(true === $attribute_value) $attribute_value = $attribute_name;

			$string_atts[] = $attribute_name . '="' . $this->escape($attribute_value) . '"';
		}

		return empty($string_atts) ? '' : (' ' . implode(' ', $string_atts));
	}

	public function is_self_closing($tag) {
		return in_array($tag, static::$self_closing_tags);
	}

	public function keep_opened($keep_opened = null) {
		if(isset($keep_opened)) {
			$this->_keep_opened = (bool) $keep_opened;

			return $this;
		}

		return $this->_keep_opened;
	}

	public function has_opened_tags() {
		return !empty($this->_opened_tags);
	}
}