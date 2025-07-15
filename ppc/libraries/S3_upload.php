<?php
require __DIR__ . '/aws/aws-autoloader.php';
use Aws\S3\S3Client;
class S3_upload
{
    protected $s3;
    public function __construct()
    {
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => 'ap-south-1',
            'credentials' => array(
                'key' => S3_CLIENT_KEY,
                'secret' => S3_CLIENT_SECRET
            )
        ]);
    }
    public function move_to_aws($key, $file)
    {
        try {
            $result = $this->s3->putObject([
                'Bucket' => 'adublisherbucket',
                'Key' => $key,
                'SourceFile' => $file,
            ]);
            return true;
        } catch (Aws\S3\Exception\S3Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_from_aws($key)
    {
        // try {
            $result = $this->s3->getObject([
                'Bucket' => S3_BUCKET,
                'Key' => $key,
            ]);
            dd($result);
            return $result;
        // } catch (Aws\S3\Exception\S3Exception $e) {
        //     return $e->getMessage();
        // }
    }

    public function remove_from_aws($key)
    {
        try {
            $result = $this->s3->deleteObject([
                'Bucket' => S3_BUCKET,
                'Key' => $key,
            ]);
            return $result;
        } catch (Aws\S3\Exception\S3Exception $e) {
            return $e->getMessage();
        }
    }
}

?>