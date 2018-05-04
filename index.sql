--declare @forecastVersion as date;
--set @forecastVersion = (select convert(varchar(10), max(transdate), 101) from svrdbs.edi.dbo.forcast_date);

declare @forecasts	table(
	transdate date, 
	suppcode varchar(100), 
	partno varchar(100), 
	month1 int, 
	month2 int, 
	month3 int, 
	month4 int, 
	month5 int, 
	total int
);

insert into @forecasts
select	TransDate as trans_date,
	SuppCode,
	rtrim(PartNo),
	ltrim(DT4QT30) as month1,
	ltrim(DT4QT31) as month2,
	ltrim(DT4QT32) as month3,
	ltrim(DT4QT33) as month4,
	ltrim(DT4QT34) as month5,
	(cast(ltrim(DT4QT30) as int) + 
	cast(ltrim(DT4QT31) as int) + 
	cast(ltrim(DT4QT32) as int) + 
	cast(ltrim(DT4QT33) as int) + 
	cast(ltrim(DT4QT34) as int)) as total_forecast
from	svrdbs.edi.dbo.forecastn 
where	RT = 'D'
	and transdate = (select convert(varchar(10), max(transdate), 101) from svrdbs.edi.dbo.forcast_date); --@forecastVersion;


select
	--tool_part.tool_id
	tool.no as tool_no
	, tool.name as tool_name
	, part.no as part_no
	, part.name as part_name
	, supplier.name
	, part.model as model
	, tool.no_of_tooling
	, tool_part.cavity
	, tool.start_value
	, tool.start_value_date
	, tool_part.part_id
	, tool_part.cavity
	, 'machine counter' as machine_counter
	, (part.first_value) as total_delivery
	, ceiling((part.first_value) / tool_part.cavity ) as total_shoot
	, isnull( forecast.month1, 0 ) as month1
	, isnull( forecast.month2, 0) as month2
	, isnull( forecast.month3, 0) as month3
	, isnull(forecast.month4, 0) as month4
	, isnull(forecast.month5, 0) as month5
	, isnull(forecast.total, 1) as total -- karena kalau 0 nanti division by zero error
	--, forecast.transdate as forecast_version
	, (( (part.first_value) + isnull(forecast.total, 1) )) as total_qty
	, ceiling( (( (part.first_value) + isnull(forecast.total, 1) )) / tool_part.cavity ) as total_shoot_forecast
	, tool.guarantee_shoot
	, (tool.guarantee_shoot - ceiling( (( (part.first_value) + isnull(forecast.total, 1) )) / tool_part.cavity ) ) as balance_shoot
from tool_part
inner join parts part on tool_part.part_id=part.id
inner join tools tool on tool.id = tool_part.tool_id
inner join suppliers supplier on supplier.id = tool.supplier_id
left join @forecasts forecast on forecast.partno = rtrim(part.no)
order by tool_id asc