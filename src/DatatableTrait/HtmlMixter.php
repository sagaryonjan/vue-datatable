<?php

namespace SagarYonjan\VueDatatable\DatatableTrait;

use Illuminate\Support\HtmlString;

trait HtmlMixter
{

    /**
     * @param $html_tags
     * @param $collect
     * @return array
     */
    public function tags($html_tag, $collect)
    {
        $data = [];
        $data['open_tag'] = ' ';
        $data['close_tags'] = [];

        if($html_tag  != null ) {

            foreach ($html_tag as $key => $tag) {

                $data['open_tag']     .= '<'.$key.' '.$this->htmlAttr($tag, $collect).'> ';
                $data['open_tag']     .= ' ';
                $data['close_tags'][]  = $key;

            }

        }

        return $data;

    }

    /**
     * @param $data
     * @return string
     */
    public function output($data) {

        $closeTags = ' ';

        foreach (array_reverse($data['close_tags']) as $end_tag) {
            $closeTags .= '</'.$end_tag. '> ';
        }

       return $this->mergeHtml($data['open_tag'], $closeTags);

    }

    /**
     * @param array $attributes
     * @param $collect
     * @return string
     */
    protected function htmlAttr($attributes = [], $collect)
    {
        $dataAttributes = array_map(function ($value, $key) use ($collect) {

            if($key == 'href') {
                $value = $this->route($value, $collect);
            } else {
                $value = $this->manageDatas($value,$collect);
            }

            return $key . '="' . $value . '"';

        }, array_values($attributes), array_keys($attributes));


        return implode(' ', $dataAttributes);
    }

    /**
     * @param $value
     * @param $collect
     * @return mixed
     */
    public function manageDatas($value, $collect)
    {
        preg_match_all('/{(.*?)}/', $value, $matches);
        $params = array_map(null,$matches[1]);

        if(isset($params)) {
            $data = [];
            foreach ($params as $param ){
                $data['{'.$param.'}'] = $collect->{$param}?$collect->{$param}:$param;
            }
            return $this->replaceWithData($data, $value);
        } else {
            return $value;
        }
    }

    /**
     * @param $params
     * @param $content
     * @return mixed
     */
    public function replaceWithData($params, $content)
    {

        $patterns     = [];
        $replacements = [];
        foreach ($params as $key =>  $value) {
            $patterns[]     = $key;
            $replacements[] = $value;
        }
        return $this->stripTags( preg_replace($patterns, $replacements, $content) );
    }

    public function stripTags($content)
    {
        return str_replace(['{', '}'],'', $content);
    }


    /**
     * @param $values
     * @param $collect
     * @return string
     */
    public function route($values, $collect) {

        return route( $values['route'], $this->getParams($values, $collect) );
    }

    /**
     * @param $values
     * @param $collect
     * @return array
     */
    public function getParams($values, $collect)
    {
        $params = [];

        foreach ($values['param'] as $parameter) {

            $params[$parameter] = $collect->{$parameter};

        }

        return $params;
    }


    /**
     * @param array ...$html
     * @return string
     */
    public function mergeHtml(...$html)
    {
        return implode(' ', $html);
    }
    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected function toHtmlString($html)
    {
        return new HtmlString($html);
    }



}