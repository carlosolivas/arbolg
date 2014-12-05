<?php
namespace s4h\core;

class DbPersonRepository implements PersonRepositoryInterface
{

	protected $file;

	public function __construct(FileRepositoryInterface $file)
    {
		$this->file = $file;
	}

	public function store($data)
    {
		//store user's avatar
		if (isset($data['photo'])) {
			$file_id = $this->file->store($data['photo']);
		} else {
			$file_id = 25;
		}
		//Store Person in the DB
        if (isset($data['id']))
            $p = Person::findOrNew($data['id']);
        else
		    $p = new Person();
		$p->file_id = $file_id;
		$p->name = $data['name'];
		$p->lastname = $data['lastname'];
		$p->mothersname = $data['mothersname'];
		$p->birthdate = $data['birthdate'];
		$p->gender = $data['gender'];
		$p->phone = $data['phone'];
		$p->email = $data['email'];

		$p->save();

		return $p->id;
	}

	public function getById($id)
    {
		return Person::findOrFail($id);
	}

	public function getFamilyByPersonId($id)
    {
		$familyGroupId = Person::findOrFail($id)->Groups()->where('GroupTypeId', '=', '1')->first()->id;

        $family = Family::with(
            'Suburb.ZipCode','Suburb.City.County.State.Country'
        )->where('group_id', '=', $familyGroupId)->get();

        return $family[0];
	}
    
    public function updateFamily($id, $data)
    {
        $family = Family::findOrFail($id);
        
        $family->name = $data['familyname'];
        $family->street = $data['street'];
        $family->numberext = $data['numberext'];
        $family->numberint = $data['numberint'];
        $family->phone = $data['phone'];
        $family->countrie_id = $data['country'];
        $family->zipcode_id = $data['zipcode'];
        $family->suburb_id = $data['suburb'];
//print_r($data);die();
        if ($family->save())
            return true;
        else
            return false;
    }

    public function updatePerson($id, $data)
    {
        $person = Person::findOrFail($id);
        $person->name = $data['name'];
        $person->lastname = $data['lastname'];
        $person->mothersname = $data['mothersname'];
        $person->birthdate = $data['date_of_birth'];
        $person->gender = $data['sex'];
        $person->phone = $data['cellphone'];
        $person->role_id = $data['role'];

        if ($person->save())
            return true;
        else
            return false;
    }
}
