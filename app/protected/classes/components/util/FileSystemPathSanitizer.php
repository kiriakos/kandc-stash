<?php
/**
 * Description of PathSanitizer
 *
 * @author kiriakos
 */
class FileSystemPathSanitizer 
extends Component
implements ISanitizer
{
    /**
     * Make sure one does not get past the base path.
     * 
     * @param type $dirty_path
     * @return type
     * @throws Exception
     */
    public function sanitize($dirty_path, $params = NULL)
    {
        $components = explode(DIRECTORY_SEPARATOR, $dirty_path);
        foreach($components as $int => $comp)
        {
            if(!$comp)
            {
                unset($components[$int]);
            }
        }
        unset($int, $comp);
        
        $back = 0;
        $fore = 0;
        $index_last = NULL;
        
        foreach($components as $index=>$c)
        {
            if($c == '..')
            {
                $back += 1;
                unset($components[$index], $components[$index_last]);
            }
            else
            {
                $fore += 1;
            }
            $index_last = $index;
        }
        unset($index, $index_last,$c);
        
        if($back > $fore)
        {
            return DIRECTORY_SEPARATOR;
        }
        else
        {
            $sanitized = join(DIRECTORY_SEPARATOR, $components);
            return DIRECTORY_SEPARATOR . $sanitized;
        }
    }
}
