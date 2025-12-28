 <?php
 $sql=[
  //this must change
    'diapo.getAll' => 'select * from diaporama',
    'news.getByLimit' => 'select * from news order by created_at desc limit 4',
    'news.getAll' => 'select * from news',
    'events.getAll' => 'select * FROM events ORDER BY created_at DESC LIMIT :limit OFFSET :offset',
    'events.getAllPublic' => 'select * FROM events WHERE isExtern = 1 ORDER BY created_at DESC LIMIT :limit OFFSET :offset',
    'events.getTotal' => 'select COUNT(*) AS total FROM events',
    'events.getTotalPublic' => 'select COUNT(*) AS total FROM events WHERE isExtern = 1',
    'partners.getAll' => 'select * from partners',

    'projects.getAll' => 'select *, left(description, 50) as description from projects;',
'projects.getById' => '
SELECT 
    p.id           AS project_id,
    p.title,
    p.description,
    p.theme,
    p.start_date,
    p.end_date,
    p.funding_type,
    p.image,
    p.status,
    p.supervisor_id,
    u.*

FROM projects p
LEFT JOIN users u ON p.supervisor_id = u.id
WHERE p.id = :id
',    
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

   'equipment.updateQ' => 'update equipment set quantity = quantity - 1 where id = :id',
   'equip.getAll' => 'select * from equipment',
    'equip.getById' => 'select * from equipment e where id = :id',
    'equip.getEquipReserve' => 'select * from reservations r join equipment e on r.equipment_id = e.id where user_id = :id_user',
    'reservation.getReservation' => '
    SELECT r.id AS r_id, r.status_res, r.start_datetime, r.end_datetime, r.purpose, u.id AS user_id,u.first_name,u.last_name,e.id AS equipment_id, e.name FROM reservations r JOIN users u ON r.user_id = u.id JOIN equipment e ON r.equipment_id = e.id',
    
    'orga.getData' => 'select * from teams',

'teams.getAll' => '
    SELECT 
        t.id AS team_id,
        t.name,
        t.description,
        t.research_themes,
        t.team_leader_id,
        t.created_at,
        u.id AS leader_id,
        u.username,
        u.email,
        u.first_name,
        u.last_name,
        u.role,
        u.profile_picture,
        u.speciality,
        u.bio,
        u.post,
        u.grade,
        u.status_user,
        u.cv
    FROM teams t
    LEFT JOIN users u ON u.id = t.team_leader_id
',
'teams.getById' => '
    SELECT 
        t.id AS team_id,
        t.name,
        t.description,
        t.research_themes,
        t.team_leader_id,
        t.created_at,
        u.id AS leader_id,
        u.username,
        u.email,
        u.first_name,
        u.last_name,
        u.role,
        u.profile_picture,
        u.speciality,
        u.bio,
        u.post,
        u.grade,
        u.status_user,
        u.cv
    FROM teams t
    LEFT JOIN users u ON u.id = t.team_leader_id where t.id = :id
',
    
    'reservation.addRes' => 'insert into reservations (equipment_id, user_id, start_datetime, end_datetime, purpose) values (:e_id, :u_id, :start, :end, :purpose)',
    'reservation.checkConflict' => '
    SELECT COUNT(*) FROM reservations
        WHERE equipment_id = :id
          AND id != :id
           AND start_datetime < :end
            AND end_datetime > :start',

    'permissions.getByUser' => 'select * from permissions p join permission_user pu on p.id = pu.permission_id where user_id = :user_id',
    'permissions.getAll' => 'select * from permissions p left join permission_user pu on p.id = pu.permission_id and user_id = :user_id',
    'permissions.add' => 'insert into permission_user (user_id, permission_id) values (:user_id, :perm_id)',
    'permissions.delete' => 'delete from permission_user where user_id= :user_id and permission_id = :perm_id',

    'roles.getAll' => 'select * from roles',
      'roles.delete' => 'delete from roles where id = :id',
      'roles.add' => 'insert into roles (name) values (:name)',

      'partners.deleteFromProject' => 'delete from project_partners where id_project = :project_id and id_part = :partner_id',
      'users.deleteFromProject' => 'delete from project_members where project_id = :project_id and member_id = :member_id',
   ];

 return $sql;
 ?>