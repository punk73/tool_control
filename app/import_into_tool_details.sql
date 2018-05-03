USE [TOOLING]
GO
/****** Object:  StoredProcedure [dbo].[importToolDetails]    Script Date: 2018-05-02 9:42:28 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [dbo].[importToolDetails] as 
begin
	declare @today as date;
	set @today = (select CONVERT(char(10), GETDATE(), 126));

	--	Step 1 simpan forecast ke table temporary
	declare @forecasts	table(
		transdate date, 
		suppcode varchar(100), 
		partno varchar(100), 
		month1 int, 
		month2 int, 
		month3 int, 
		month4 int, 
		month5 int, 
		total int);
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
			and transdate = (select convert(varchar(10), max(transdate), 101) from svrdbs.edi.dbo.forcast_date)
	--group by PartNo, SuppCode, TransDate ;
	
	--buat table temporary untuk store gabungan part dan part details di hari ini.
	declare @partThatHasDetails as table (
		id int,
		part_no varchar(40),
		first_value int,
		date_of_first_value date,
		total_delivery int,
		trans_date date
	)
	insert into @partThatHasDetails
	select 
		parts.id,
		parts.no as part_no,
		parts.first_value,
		parts.date_of_first_value,
		part_details.total_delivery,
		part_details.trans_date
	from part_details left join parts on part_details.part_id = parts.id
	where trans_date = @today;

	--test if @partThatHasDetails is ok--
	--select *, 'part that has detail' as comment from @partThatHasDetails;


	--get toolpart from first @partThatHasDetails store as @toolpartThatHasPartDetail --
	declare @toolpartThatHasPartDetail as table (
		id int,
		part_no varchar(40),
		first_value int,
		date_of_first_value date,
		total_delivery int,
		trans_date date,
		tool_id int,
		cavity float,
		is_independent int
	) 
	insert into @toolpartThatHasPartDetail
	select 
		a.*,
		tool_part.tool_id,
		tool_part.cavity,
		tool_part.is_independent
	from @partThatHasDetails a 
	inner join tool_part on a.id = tool_part.part_id
	where tool_part.deleted_at is null; -- yg belum dihapus


	--check the result
	--select *, 'toolpart that  has part detail' as comment from @toolpartThatHasPartDetail;
	--return;

	--show the result
	declare @main as table (
		tool_id int,
		part_id int,
		is_indepent int,
		guarantee_shoot int,
		total_delivery int,
		cavity float,
		total_shoot int,
		balance_shoot int,
		guarantee_after_forecast int,
		trans_date date
		,total_forecast int
	)
	insert into @main
	select 
		tools.id as tool_id --toolid
		,a.id  as part_id
		, a.is_independent
		, tools.guarantee_shoot
		,a.total_delivery as total_delivery
		,a.cavity
		,( a.total_delivery / a.cavity ) as total_shoot --total_shoot
		,( tools.guarantee_shoot - ( a.total_delivery / a.cavity ) ) as balance_shoot --balance_shoot
		,( (( tools.guarantee_shoot - ( a.total_delivery / a.cavity ) ) * a.cavity ) / forecast.total / 5 ) as guarantee_after_forecast -- guarantee_after_forecast
		, @today as trans_date -- trans_date
		, isnull(forecast.total, 0 ) as total_forecast
	from @toolpartThatHasPartDetail a 
	left join tools on tools.id = a.tool_id
	left join @forecasts forecast on a.part_no = forecast.partno
	
	--select * from @main;
	--return;

	declare @suffix as table (
		tool_id int,
		part_id int,
		is_indepent int,
		guarantee_shoot int,
		total_delivery int,
		cavity float,
		total_shoot int,
		balance_shoot int,
		guarantee_after_forecast int,
		trans_date date
		,total_forecast int
	)
	insert into @suffix
	select * from @main a where a.is_indepent = 1;

	declare @nonSuffix as table (
		tool_id int,
		part_id int,
		is_indepent int,
		guarantee_shoot int,
		total_delivery int,
		cavity float,
		total_shoot int,
		balance_shoot int,
		guarantee_after_forecast int,
		trans_date date
		,total_forecast int
		,total_shoot_after_forecast int
	)
	insert into @nonSuffix
	select *, CEILING(((total_forecast / cavity ) + total_shoot)) as total_shoot_after_forecast from @main a where a.is_indepent = 0;
	
	declare @suffixGroupBytoolId as table (
	   tool_id int,
	   part_id int,
	   gurantee_shoot int,
	   total_shoot int,
	   balance_shoot int,
	   guarantee_after_forecast int,
	   trans_date date,
	   comment varchar(100)
	)
	insert into @suffixGroupBytoolId
	select 
		tool_id
		,max(part_id) as part_id
		, (select guarantee_shoot from @suffix a where tool_id = tool_id group by tool_id, guarantee_shoot )  as guarantee_shoot
		,SUM(total_shoot) as total_shoot
		, ( (select guarantee_shoot from @suffix a where tool_id = tool_id group by tool_id, guarantee_shoot ) - SUM(total_shoot) ) as balance_shoot
		,( ((select guarantee_shoot from @suffix a where tool_id = tool_id group by tool_id, guarantee_shoot ) - SUM(total_shoot) ) / (SUM(total_forecast) / 5 )) as guarantee_after_forecast -- guarantee_after_forecast
		, @today as trans_date
		,'suffix' as comment
	from @suffix
	group by tool_id;


	--select *, 'suffix' as comment from @suffix;
	--select * from @suffixGroupBytoolId;

	declare @nonSuffixReference as table (
	  tool_id int,
	  total_shoot_after_forecast int,
	  trans_date date,
	  comment varchar(100)
	)
	insert into @nonSuffixReference
	select 
		tool_id
		, max( total_shoot_after_forecast ) as total_shoot_after_forecast
		, @today as trans_date
		, 'non suffix' as comment 
	from @nonSuffix
	group by tool_id;

	declare @nonSuffixGroupByToolID as table (
		tool_id int,
		part_id int,
		is_indepent int,
		guarantee_shoot int,
		total_delivery int,
		cavity float,
		total_shoot int,
		balance_shoot int,
		guarantee_after_forecast int,
		trans_date date
		,total_forecast int
		,total_shoot_after_forecast int
	)

	insert into @nonSuffixGroupByToolID
	select 
		a.*
	from @nonSuffix a
	inner join @nonSuffixReference b
	on a.tool_id = b.tool_id and a.total_shoot_after_forecast = b.total_shoot_after_forecast
	
	insert into tool_details (
	   [tool_id]
      ,[total_shoot]
      ,[guarantee_after_forecast]
      ,[balance_shoot]
      ,[trans_date]
	)
	select 
		tool_id
		, total_shoot
		, guarantee_after_forecast
		, balance_shoot
		, trans_date
	from @nonSuffixGroupByToolID;

	insert into tool_details (
	   [tool_id]
      ,[total_shoot]
      ,[guarantee_after_forecast]
      ,[balance_shoot]
      ,[trans_date]
	)
	select 
		tool_id
		, total_shoot
		, guarantee_after_forecast
		, balance_shoot
		, trans_date
	from @suffixGroupBytoolId;

	select * from tool_details where trans_date = @today


end