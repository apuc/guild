<?php

namespace common\services;

use common\models\ProjectTask;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\helpers\ArrayHelper;

class ImportProjectTaskService
{
    /**
     * @param array $tasks
     * @return string|void
     */
    public function importTasks(array $tasks)
    {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'ID проекта')
                ->setCellValue('C1', 'Название проекта')
                ->setCellValue('D1', 'Задача')
                ->setCellValue('E1', 'Дата создания')
                ->setCellValue('F1', 'Дата обновления')
                ->setCellValue('G1', 'Дедлайн')
                ->setCellValue('H1', 'Описание')
                ->setCellValue('I1', 'Статус')
                ->setCellValue('J1', 'Колонка')
                ->setCellValue('G1', 'ID создателя задачи')
                ->setCellValue('K1', 'Создатель задачи')
                ->setCellValue('L1', 'ID исполнителя')
                ->setCellValue('M1', 'Приоритет')
                ->setCellValue('N1', 'Исполнитель')
                ->setCellValue('O1', 'Количество коментариев')
                ->setCellValue('P1', 'Участники')
                ->setCellValue('Q1', 'Теги')
                ->setCellValue('R1', 'Приоритет выполнения');

            $i = 2;
            /** @var ProjectTask $task */
            foreach ($tasks as $task) {
                $sheet
                    ->setCellValue('A' . $i, $task->id)
                    ->setCellValue('B' . $i, $task->project_id)
                    ->setCellValue('C' . $i, $task->project->name)
                    ->setCellValue('D' . $i, $task->title)
                    ->setCellValue('E' . $i, $task->created_at)
                    ->setCellValue('F' . $i, $task->updated_at)
                    ->setCellValue('G' . $i, $task->dead_line)
                    ->setCellValue('H' . $i, $task->description)
                    ->setCellValue('I' . $i, ArrayHelper::getValue(ProjectTask::getStatus(), $task->status))
                    ->setCellValue('J' . $i, $task->column->title)
                    ->setCellValue('G' . $i, $task->user_id)
                    ->setCellValue('K' . $i, $task->user->userCard->fio ?? ($task->user->username ?? 'kkk'))
                    ->setCellValue('L' . $i, $task->executor_id)
                    ->setCellValue('M' . $i, $task->priority)
                    ->setCellValue('N' . $i, $task->executor->userCard->fio ?? ($task->executor->username ?? 'ggg'))
                    ->setCellValue('O' . $i, $task->getCommentCount())
                    ->setCellValue('P' . $i, $task->getTaskUsersToStr())
                    ->setCellValue('Q' . $i, $task->getMarkTitleToStr())
                    ->setCellValue('R' . $i, $task->execution_priority);
                $i++;
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode('tasks.xlsx').'"');
            $writer->save('php://output');
            exit();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}