<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GrahamCampbell\Flysystem\Facades\Flysystem;






class File extends Model
{
    protected $fillable = ["path", "file"];


    #region functions

    public static function createFile($file,$file_name, $folder)
    {
        if (count(explode("base64,",$file)) > 1 && File::is_base64_encoded(explode("base64,",$file)[1]))
        {
            $extension = ".".explode('/', mime_content_type($file))[1];
            $fd = [
                'file_name'=>$file_name,
                'extension'=>$extension,
                'folder'=>$folder,
                'file'=>$file
            ];
            return File::mkFile($fd);
        }else{
            return "deu ruim";
        }
    }

    public static function mkFile($data)
    {
        $file = Str::kebab($data['file_name'])."_".time().$data['extension'];
        // $storedFile = Flysystem::putFileAs("public/".$data['folder'], $data['file'], $file);
        // base64_decode($data['file'])
        // Flysystem::put("public/".$data['folder'].$file, explode("base64,",$data['file'])[1]  );
        $path = "storage/".$data['folder']."/";
        File::base64_to_jpeg($data['file'], $path.$file );

        $file = File::create([
            'path'=>$path,
            'file'=>$file
        ]);

        return $file;
    }


    public static function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 
    
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );
    
        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    
        // clean up the file resource
        fclose( $ifp ); 
    
        return $output_file; 
    }

    public static function is_base64_encoded($data)
    {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
        return TRUE;
        } else {
        return FALSE;
        }
    }

    #endregion
}
