 <?php
 $sql=[
    'diapo.getAll' => 'select * from diaporama',
    'news.getByLimit' => 'select * from news order by created_at desc limit 4',
    'news.getAll' => 'select * from news',
    'events.getAll' => 'select * FROM events ORDER BY created_at DESC LIMIT :limit OFFSET :offset',
    'events.getAllPublic' => 'select * FROM events WHERE isExtern = 1 ORDER BY created_at DESC LIMIT :limit OFFSET :offset',
    'events.getTotal' => 'select COUNT(*) AS total FROM events',
    'events.getTotalPublic' => 'select COUNT(*) AS total FROM events WHERE isExtern = 1',
    'partners.getAll' => 'select * from partners',
    'projects.getAll' => 'select *, left(description, 50) as description from projects;',
    'projects.getById' => 'select * from projects p join users u on p.supervisor_id = u.id where p.id = :id',
    'members.getMembersByProjectId' => 'select * from project_members pm join users u on pm.member_id = u.id where pm.project_id = :project_id',
    'partners.getByProject' => 'select pa.* from project_partners pp join partners pa on pp.id_part = pa.id where pp.id_project = :project_id',
    'pubs.getByProjectId' => 'select * from publications where status="valide" and project_id = :project_id',
    'pubs.getById' => 'select * from publications where id = :id',
    'pubs.getAll' => 'select p.*, u.id as user_id, u.first_name, u.last_name from publications p left join publication_authors pa on pa.publication_id = p.id left join users u on u.id = pa.user_id where p.status="valide";',
    'pubs.getPubsUser' => 'select * from publication_authors pa join publications p on pa.publication_id = p.id where user_id = :id_user',
    'members.getAll' => 'select * from users u join project_members pm on u.id = pm.member_id',
    'users.getAuthorByPub' => 'select u.* from users u join publication_authors pa on u.id = pa.user_id where pa.publication_id = :publication_id',
    'users.getById'=> 'select * from users where id = :id',
    'users.getDir' => "select *from users where role = 'directeur'",
    'users.getAll' => 'select * from users order by created_at',
    'user.login' => 'select * FROM users WHERE username = :username',
    'users.getMembers' => 'select * from users where id_team = :id',
    'users.updateProfile' => 'update users set first_name = :first_name, last_name = :last_name, email = :email, profile_picture = :pp, speciality = :speciality, post = :post, grade = :grade, bio = :bio, cv = :cv where id = :user_id',
    'users.updateUser' => 'update users set first_name = :first_name, last_name = :last_name, email = :email, profile_picture = :pp, speciality = :speciality, post = :post, grade = :grade, bio = :bio, cv = :cv, username = :username, password = :pw, status_user = :status, role = :role where id = :user_id',
   'users.createUser' => 'insert into users (first_name, last_name, email, profile_picture,speciality, post, grade, bio, cv, username, password, status_user, role)  values (:first_name, :last_name, :email, :pp, :speciality, :post, :grade, :bio, :cv, :username, :pw, :status, :role)',
   
   'users.deleteUser' => 'delete from users where id = :id',

   'equip.getAll' => 'select * from equipment',
    'equip.getById' => 'select e.id, e.name from equipment e where id = :id',
    'equip.getEquipReserve' => 'select * from reservations r join equipment e on r.equipment_id = e.id where user_id = :id_user',
    'reservation.getReservation' => 'select * from reservations r join users u join equipment e on r.user_id=u.id and r.equipment_id = e.id',
    'orga.getData' => 'select * from teams',
    'teams.getAll' => 'select * from teams t left join users u on u.id = t.team_leader_id',
    'teams.getById' => 'select * from teams t join users u on t.team_leader_id = u.id where t.id = :id',
    'reservation.addRes' => 'insert into reservations (equipment_id, user_id, start_datetime, end_datetime, purpose) values (:e_id, :u_id, :start, :end, :purpose)',
    'permissions.getByUser' => 'select * from permissions p join permission_user pu on p.id = pu.permission_id where user_id = :user_id',
    'permissions.getAll' => 'select * from permissions p left join permission_user pu on p.id = pu.permission_id and user_id = :user_id',
    'permissions.add' => 'insert into permission_user (user_id, permission_id) values (:user_id, :perm_id)',
    'permissions.delete' => 'delete from permission_user where user_id= :user_id and permission_id = :perm_id',

    'roles.getAll' => 'select * from roles',
      'roles.delete' => 'delete from roles where id = :id',
      'roles.add' => 'insert into roles (name) values (:name)'

   ];

 return $sql;
 ?>