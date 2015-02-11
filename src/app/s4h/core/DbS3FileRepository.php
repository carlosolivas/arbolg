<?php
namespace s4h\core;

class DbS3FileRepository implements FileRepositoryInterface
{
    protected $bucket;
    protected $bucketURL;

    public function __construct()
    {
        $this->bucket = 'soft4h';
        $this->bucketURL = "https://s3.amazonaws.com/".$this->bucket."/";
    }

    public function store($file)
    {
        $fileExt = $file->getClientOriginalExtension();
        $fileName = sha1(time().time()).".".$fileExt;

        //Store file in S3
        $s3 = \App::make('aws')->get('s3');
        $s3->putObject(array(
            'Bucket'     => $this->bucket,
            'Key'        => $fileName,
            'SourceFile' => $file->getClientOriginalName(),
            'Body'         => file_get_contents($file),
            'ACL'        => 'public-read'
        ));

        //Store reference in the DB
        $f = new File();
        $f->fileName = $file->getClientOriginalName();
        $f->fileURL = $this->bucketURL.$fileName;
        $f->fileType = $file->getClientMimeType();
        $f->user_id = \Auth::user()->id;
        $f->save();

        return $f->id;
    }

}
