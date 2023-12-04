<?php


namespace frontend\modules\api\models\company\mappers;

use frontend\modules\api\models\company\dto\CompanyPersonnelDto;
use frontend\modules\api\models\project\ProjectUser;
use frontend\modules\api\services\TaskService;

class CompanyPersonnelMapper
{
    /**
     * @param ProjectUser $projectUser
     * @return CompanyPersonnelDto
     */
    public static function map(ProjectUser $projectUser): CompanyPersonnelDto
    {
        $dto = new CompanyPersonnelDto();

        $dto->userId = $projectUser->user_id;
        $dto->fio = $projectUser->card->fio ?? null;
        $dto->position = $projectUser->card->position->name ?? null;
        $dto->level = $projectUser->card->level ?? null;
        $dto->projectName = $projectUser->project->name;
        $dto->openTaskCount = TaskService::getOpenTaskCount($projectUser->user_id, $projectUser->project_id);
        $dto->hoursWorkedForCurrentMonth = TaskService::getHoursWorkedForCurrentMonth($projectUser->user_id, $projectUser->project_id);

        return $dto;
    }

    /**
     * @param array $projectUsers
     * @return array
     */
    public static function mapAll(array $projectUsers): array
    {
        return array_map(function (ProjectUser $projectUser) {
            return self::map($projectUser);
        }, array_values($projectUsers));
    }
}
