<form method="GET" action="index.php">
    <input type="hidden" name="page" value="projets">

    <select name="status">
        <option value="">All statuses</option>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
    </select>

    <select name="year">
        <option value="">All years</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
    </select>

    <button type="submit">Filter</button>
</form>
<?php
class ProjectFilter {
    private $projects;
    
    public function __construct(array $projects) {
        $this->projects = $projects;
    }
    
    public function byStatus(string $status): self {
        $this->projects = array_filter($this->projects, 
            fn($project) => $project['status'] === $status
        );
        return $this;
    }
    
    public function byTheme(string $theme): self {
        $this->projects = array_filter($this->projects, 
            fn($project) => $project['theme'] === $theme
        );
        return $this;
    }
    
    public function getResults(): array {
        return array_values($this->projects); // Reset keys
    }
}

// // Usage
// $filter = new ProjectFilter($projects);
// $results = $filter->byStatus('active')->byTheme('web')->getResults();