from fastapi import FastAPI,HTTPException
from models import PetCreate
from models import vetCreate
from models import BookingCreate
from datetime import datetime
import qrcode
import os
import uuid

myapp=FastAPI()

pets=[]
vets=[]
bookings=[]
def generate_qr(pet_id:str):

  folder=("qrcodes")  
  os.makedirs(folder,exist_ok=True)
  pet_url=f"http://192.168.0.244:8000/pets/{pet_id}"
  qr=qrcode.make(pet_url)
  file_path=os.path.join(folder,f"{pet_id}.png")
  qr.save(file_path)
  return file_path


  return pets
@myapp.post("/pets")
def cerate_pets(pet:PetCreate):
  pet_id=str(uuid.uuid4())
  new_pet={
    "id":pet_id,
    "pet_name":pet.name,
    "pet_datea_of_birth":pet.dob ,
    "owner_name":pet.owner_name,
    "pet_breed":pet.breed,
    "vaccination_date":pet.vaccination_date
    }
  pets.append(new_pet)
  qr_path=generate_qr(pet_id)

  return{
    "message":"pet registerd successfully",
    "pet_id":pet_id,
    "qr_path":qr_path
}

@myapp.get("/allpets")
def get_all_pets():
  return pets 



@myapp.get("/pets/{pet_id}")
def get_pet(pet_id: str):
    for pet in pets:
        if pet["id"] == pet_id:
            today = datetime.today().date()
            vaccine_date = datetime.strptime(
                pet["vaccination_date"], "%Y-%m-%d"
            ).date()

            if vaccine_date < today:
                status = " Vaccination Overdue"
            else:
                status = " Vaccination Scheduled"

            return {
                "pet_details": pet,
                "vaccination_status": status
            }

    raise HTTPException(status_code=404, detail="Pet not found")


@myapp.post("/vets")
def add_vets(vet:vetCreate):
  vet_id=str(uuid.uuid4())
  new_vet={
    "id":vet_id,
    "name":vet.vet_name,
    "specialization":vet.specialization
}
  vets.append(new_vet)

  return{
    "vet_id":vet_id,
    "name":vet.vet_name
  }
@myapp.get("/allvets")
def get_vets():
  return vets
@myapp.post("/bookings")
def create_booking(booking: BookingCreate):
    # Check pet exists
    pet_exists = any(p["id"] == booking.pet_id for p in pets)
    if not pet_exists:
        raise HTTPException(status_code=404, detail="Pet not found")

    # Check vet exists
    vet_exists = any(v["id"] == booking.vet_id for v in vets)
    if not vet_exists:
        raise HTTPException(status_code=404, detail="Vet not found")

    booking_id = str(uuid.uuid4())

    new_booking = {
        "id": booking_id,
        "pet_id": booking.pet_id,
        "vet_id": booking.vet_id,
        "booking_date": booking.booking_date
    }

    bookings.append(new_booking)

    return {
        "message": "Appointment booked successfully",
        "booking_id": booking_id
    }


@myapp.get("/bookings")
def get_all_bookings():
    return bookings


@myapp.get("/vets/{vet_id}/appointments")
def get_vet_appointments(vet_id: str):
    vet_bookings = []

    for booking in bookings:
        if booking["vet_id"] == vet_id:
            vet_bookings.append(booking)

    return {
        "vet_id": vet_id,
        "total_appointments": len(vet_bookings),
        "appointments": vet_bookings
    }

 


  


   




        






  
  













  

  



