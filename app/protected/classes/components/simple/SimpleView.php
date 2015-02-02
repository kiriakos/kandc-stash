<?php
/**
 * Just echoes out render Data
 *
 * @author kiriakos
 */
class SimpleView 
extends Component
implements IView
{
    /**
     * 
     * @param \IRenderData $data
     * @return string   The payload to return to the User Agent
     */
    public function compute(\IRenderData $data) 
    {
        return print_r($data->getData(), TRUE);
    }
}
