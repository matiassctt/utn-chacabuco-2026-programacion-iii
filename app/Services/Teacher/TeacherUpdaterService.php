<?php 

namespace App\Services\Teacher;

use App\Converter\Teacher\TeacherToTeacherResponseConverter;
use App\Dto\Request\Teacher\TeacherRequest;
use App\Dto\Response\Teacher\TeacherResponse;
use App\Models\TeacherModel;

final class TeacherUpdaterService {
    private TeacherModel $teacherModel;
    private TeacherFinderService $teacherFinderService;
    private TeacherToTeacherResponseConverter $converter;

    public function __construct() {
        $this->teacherModel = new TeacherModel();
        $this->teacherFinderService = new TeacherFinderService();
        $this->converter = new TeacherToTeacherResponseConverter();
    }

    public function update(TeacherRequest $request, int $id): TeacherResponse
    {
        $teacher = $this->teacherFinderService->find($id);
        
        $teacher->update($request);

        $teacher = $this->teacherModel->update($teacher);

        $response = $this->converter->convert($teacher);

        return $response;
    }
}