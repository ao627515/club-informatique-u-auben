<?php

namespace App\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class CandidateData extends Data
{
    public function __construct(
        public int $userId,
        public UploadedFile $photoOfficielle,
        public UploadedFile $programme,
        public string $vision,
        public string $motivations,
        public string $status = 'pending',
    ) {}
}
