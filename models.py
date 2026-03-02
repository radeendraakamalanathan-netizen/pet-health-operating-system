from pydantic import BaseModel


class PetCreate (BaseModel):
    name: str
    dob: str
    owner_name: str
    breed: str
    vaccination_date: str

class vetCreate(BaseModel):
    vet_name:str
    specialization:str

class BookingCreate(BaseModel):
    pet_id: str
    vet_id: str
    booking_date: str  
