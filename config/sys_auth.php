    <?php
return [
    "user" => "users",
    "admin" => "admins",
    "session" => [
        "user_choose" => "admin_choose_user_id",
    ],
    "auth_project" => [
        "owner" => [
            "id" => 1,
            "name" => "オーナー"
        ],
        "admin" => [
            "id" => 1,
            "name" => "管理者"
        ]
    ],
    "allow_permission" => [
        "user.task.index",
        "user.project.index",
        "user.project.check.permission.email",
        "user.project.active.user",
        "user.project.create",
        "user.chart.gantt",
        "user.kanban.board",
        "user.task.update.status",
    ]
];
