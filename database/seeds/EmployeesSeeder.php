<?php

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Seeder;

class EmployeesSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generalDirector = $this->getEmployeeAttributes(
            'general_director',
            200000,
            [
                $this->buildFinanceDepartment(),
                $this->buildTechnicalDepartment(),
            ]
        );


        Employee::create($generalDirector);
    }

    /**
     * @param string $positionSlug
     * @param int|null $wage
     * @param array $children
     * @return array
     */
    protected function getEmployeeAttributes(string $positionSlug, ?int $wage = null, array $children = []) : array
    {
        $position = Position::whereSlug($positionSlug)->first();

        return [
            'full_name' => $this->faker->name,
            'position_id' => $position->id,
            'wage' => $wage ?? mt_rand(1000, 10000),
            'children' => $children,
        ];
    }

    /**
     * @return array
     */
    protected function buildFinanceDepartment() : array
    {
        $chiefAccountantChildren = [];

        for ($i = 1; $i <= 100; $i++) {
            $chiefAccountantChildren[] = $this->getEmployeeAttributes('accountant', 20000);
        }

        $chiefAccountant = $this->getEmployeeAttributes('chief_accountant', 45000, $chiefAccountantChildren);

        $financialDirector = $this->getEmployeeAttributes('financial_director', 100000, [$chiefAccountant]);

        return $financialDirector;
    }

    /**
     * @return array
     */
    protected function buildStewardDepartment() : array
    {
        $stewards = [];

        for ($i = 1; $i <= 5; $i++) {
            $stewardChildren = [];

            for ($k = 1; $k <= 20; $k++) {
                $stewardChildren[] = $this->getEmployeeAttributes('cleaner', 5000);
            }

            for ($j = 1; $j <= 10; $j++) {
                $stewardChildren[] = $this->getEmployeeAttributes('locksmith', 7000);
            }

            $stewards[] = $this->getEmployeeAttributes('steward', 10000, $stewardChildren);
        }

        return $this->getEmployeeAttributes('chief_steward', 20000, $stewards);
    }

    /**
     * @return array
     */
    protected function buildDevelopmentTeam() : array
    {
        $developmentTeamManagerChildren = [];

        for ($i = 1; $i <= 6; $i++) {
            $developmentTeamManagerChildren[] = $this->getEmployeeAttributes('junior_developer', 10000);
        }

        for ($i = 1; $i <= 3; $i++) {
            $developmentTeamManagerChildren[] = $this->getEmployeeAttributes('middle_developer', 15000);
        }

        $developmentTeamManagerChildren[] = $this->getEmployeeAttributes('senior_developer', 20000);

        return $this->getEmployeeAttributes('development_team_manager', 30000, $developmentTeamManagerChildren);
    }

    /**
     * @return array
     */
    protected function buildEngineerTeam() : array
    {
        $engineerTeamManagerChildren = [];

        for ($i = 1; $i <= 6; $i++) {
            $engineerTeamManagerChildren[] = $this->getEmployeeAttributes('junior_engineer', 10000);
        }

        for ($i = 1; $i <= 3; $i++) {
            $engineerTeamManagerChildren[] = $this->getEmployeeAttributes('middle_engineer', 15000);
        }

        $engineerTeamManagerChildren[] = $this->getEmployeeAttributes('senior_engineer', 20000);

        return $this->getEmployeeAttributes('engineering_team_manager', 30000, $engineerTeamManagerChildren);
    }

    /**
     * @return array
     */
    protected function buildTechnicalDepartment() : array
    {
        $technicalDirectorChildren = [];

        for ($i = 1; $i <= 5; $i++) {
            $middleManagers = [];

            for ($k = 1; $k <= 5; $k++) {
                $middleChildren = [];

                for ($j = 1; $j <= 5; $j++) {
                    $middleChildren[] = $this->buildEngineerTeam();
                    $middleChildren[] = $this->buildDevelopmentTeam();
                }

                $middleManagers[] = $this->getEmployeeAttributes('middle_manager', 50000, $middleChildren);
            }

            $technicalDirectorChildren[] = $this->getEmployeeAttributes('senior_manager', 70000, $middleManagers);
        }

        $technicalDirectorChildren[] = $this->buildStewardDepartment();

        return $this->getEmployeeAttributes('technical_director', 100000, $technicalDirectorChildren);
    }
}
