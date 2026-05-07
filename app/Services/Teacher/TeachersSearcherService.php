<?php 

namespace App\Services\Teacher;

use App\Converter\Teacher\TeacherToTeacherResponseConverter;
use App\Dto\Request\Teacher\TeacherFilterRequest;
use App\Dto\Response\Teacher\TeacherResponse;
use App\Models\TeacherModel;

final class TeachersSearcherService {

    private TeacherModel $teacherModel;
    private TeacherToTeacherResponseConverter $converter;

    public function __construct() {
        $this->teacherModel = new TeacherModel();
        $this->converter = new TeacherToTeacherResponseConverter();
    }

    /**
     * @return TeacherResponse[]
     */
    public function searchResponses(TeacherFilterRequest $request): array
    {
        $entities = $this->teacherModel->search($request);

        $responses = [];
        foreach ($entities as $entity) {
            $responses[] = $this->converter->convert($entity);
        }

        return $responses;
    }
}