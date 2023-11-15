
-- 1
Select c.VAT,c.name,p.phone
From employee e, doctor d, client c, phone_number_client p, consultation co, appointment a
Where a.VAT_client=c.VAT
	and co.VAT_doctor=a.VAT_doctor
	and a.VAT_doctor=d.VAT
	and d.VAT=e.VAT 
	and e.name= ‘Jane Sweettoth’
Order by c.name

-- 2
((Select t.VAT, s.evaluation, s.description, e.name
From trainee_doctor t, supervision_report s, employee e
Where (s.evaluation < 3 or s.description like ‘%insufficient%’) 
	and t.VAT=d.VAT
	and d.VAT=e.VAT)
intersect
(Select e.name
From trainee_doctor t, supervision_report s, employee e, permanente_doctor pe
Where (s.evaluation < 3 or s.description like ‘%insufficient%’)
	and t.supervisor=pe.VAT
	and pe.VAT=d.VAT 
	and d.VAT=e.VAT))
Desc s.evaluation

--3 
Select c.name,c.city,c.VAT
From consultation co, client c, appointment a
Where c.VAT=a.VAT_client 
	and co.date_timestamp=a.date_timestamp
	and (co.SOAP_O like ‘%gingivitis%’ or co.SOAP_O like ‘%periodontitis%’)
	and co.date_timestamp = (select max(date_timestamp)	from consultation)
	
--4 
Select c.name, c.VAT, c.street, c.city, c.zip
From client c, consultation co, appointment a
Where c.VAT=a.VAT_client
	and co.SOAP_O is null
	and co.SOAP_S is null
	and co.SOAP_A is null
	and co.SOAP_P is null
	
--5
Select dc.ID, dc.description, count(distinct m.name)
From diagnostic_code dc, medication m, prescription pre, consultation_diagnostic cd
Where cd.ID=dc.ID 
	and pre.ID=cd.ID
	and pre.name=m.name
Group by dc.ID
Asc count(distinct m.name)

--6
(select avg(count ca.VAT_nurse), avg (count cd.ID), avg(count pic.name),avg(count pres.name)
From consultation_assistant ca, consultation_diagnostic cd, procedure_in_consultation pic, prescription pres, client c
Where DATEPART(yy,ca.date_timestamp)=2019
	and DATEPART(yy,pic.date_timestamp)= 2019
	and DATEPART(yy,cd.date_timestamp)=2019
	and DATEPART(yy,pres.date_timestamp)=2019
Group by c.age
Having c.age <=18)
Union
(select avg(count ca.VAT_nurse), avg (count cd.ID), avg(count pic.name),avg(count pres.name)
From consultation_assistant ca, consultation_diagnostic cd, procedure_in_consultation pic, prescription pres, client c
Where DATEPART(yy,ca.date_timestamp)=2019 
	and DATEPART(yy,pic.date_timestamp)= 2019
	and DATEPART(yy,cd.date_timestamp)=2019
	and DATEPART(yy,pres.date_timestamp)=2019
Group by c.age
Having c.age >18)

--7
Select m.name
From medication m, diagnostic_code dc, prescription pre, consultation_diagnostic cd
Where m.name=pre.name 
	and dc.ID=cd.ID 
	and cd.ID=pre.ID
	and count (pre.name) >all (select count(name) from prescription group by name)
Group by pre.ID

--8
((select m.name, m.labs
From prescription pre, diagnostic_code dc, medication m, consultation_diagnostic cd
Where DATEPART(yy,pre.date_timestamp)=2019
	and dc.description like ‘%dental%’ 
	and dc.description like ‘%cavities%’
	and cd.ID=dc.ID 
	and cd.ID=pre.ID 
	and m.name=pre.name)
Except
(select m.name, m.labs
From prescription pre, diagnostic_code dc, medication m, consultation_diagnostic cd
Where DATEPART(yy,pre.date_timestamp)=2019
	and dc.description like ‘%infectiouse%’ 
	and dc.description like ‘%disease%’ 
	and cd.ID=dc.ID 
	and cd.ID=pre.ID 
	and m.name=pre.name))
Order by m.name,m.labs

--9
Select c.name,c.street,c.city,c.zip
From client c, appointment a
Appointment natural join consultation
Where DATEPART(yy,a.date_timestamp)=2019 
	and a.VAT_client=c.VAT
	
	
_______________________________

--1
update employee
set street = 'Sierps' and city = 'Sevilha'
where name='Jane Sweettoth'

--2
update employee
set salary = salary * 1.05
where count(VAT_doctor)>100
	(select count (VAT_doctor)
	from appointment
	where DATEPART (yy, a.date_timestamp)=2019
	group by VAT_doctor)
	
--3
delete from employee e, appointment a, consultation co, prescription pres,
	procedure_in_consultation pic, consultation_diagnostic cd
where c.name = 'Jane Sweettoth' 
	and c.VAT = a.VAT_doctor
	and a.VAT_doctor = co.VAT_doctor
	and co. VAT_doctor = pres.VAT_doctor
	and pres VAT_doctor = pic.VAT_doctor
	and pic.VAT_doctor = cd.VAT_doctor

--4
select dc.ID
from diagnostic_code dc
where dc.description like'%gingivitis%'
insert into diagnostic_code values (0013,'periodontitis')
update consultation_diagnostic
from consultation_diagnostic cd , procedure_charting pc
set cd.ID = 0013 
	and cd.description = 'periodontitis'
where cd.ID = 0001
	and avg(pc.measure)>4
	
	
_______________________________

VIEWS

create view dim_date as 
	(select co.date_timestamp, DAY (co.date_timestamp), MONTH (co.date_timestamp), YEAR(co.date_timestamp)
	from consultation co)
	
create view dim_client as 
	(select VAT, gender, age
	from client)
	
create view dim_location_client as 
	(select zip, city
	from client)


__________________________
	
create view facts_consults as	
	(select c.VAT, dd.datee, c.zip, count(distinct pr.name), count(distinct m.name), count(distinct dc.ID)
	from client c, dim_date dd, proceduree pr, medication m, diagnostic_code dc)



