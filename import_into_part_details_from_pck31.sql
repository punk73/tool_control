USE [TOOLING]
GO
/****** Object:  StoredProcedure [dbo].[impPartDetailPCK31]    Script Date: 2018-05-02 1:31:35 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [dbo].[impPartDetailPCK31]
as
begin
	--	Step 1 - select left join tabel partrelation dengan partmaster dan masukkan ke table temporary
	declare		@partcomparetmp		table(	childpartid varchar(100), childpartno varchar(100), childdofv date,
											parentpartid varchar(100), parentpartno varchar(100), parentdofv date );
	insert into @partcomparetmp
	select		a.children_part_id,
				(select no from parts where id = a.children_part_id), 
				(select date_of_first_value from parts where id = a.children_part_id), 
				a.parent_part_id,
				(select no from parts where id = a.parent_part_id),
				(select date_of_first_value from parts where id = a.parent_part_id)
	from		part_relations a;

	--	Step 2 - select left join tabel partmaster dengan table @partcomparetmp dan masukkan ke table temporary
	declare		@partstmp		table(	rowid int identity(1,1),	partid int, partno varchar(100),	datefirstval date, 
										parentpartid varchar(100),	parentpartno varchar(100),			parentdofv date );

	insert into @partstmp (partid, partno, datefirstval, parentpartid, parentpartno, parentdofv)
	select		rtrim(a.id), rtrim(a.no), a.date_of_first_value,
				rtrim(b.parentpartid), rtrim(b.parentpartno), b.parentdofv
	from		parts a
	left join	@partcomparetmp b on b.childpartid = a.id
	where		a.deleted_at is null
	order by	b.parentpartid desc;

	--	Step 3 - cek part number di table part detail
	--	Step 3 - a. jika ada, cek data pck31
	declare @i as int;
	declare @max as int;
	declare @partidtmp as varchar(100);
	declare @partnotmp as varchar(100);
	declare @partDofvTmp as date;
	declare @cekPartDetail as int;
	declare @totalDelivery as int;
	declare @cekPck31 as int;
	declare @totalDeliveryPck31 as int;
	declare @partIdParentTmp as int;
	declare @partNoParentTmp as varchar(100);
	declare @partDofvParentTmp as date;

	declare	@summarytemp table(rowid int identity(1,1), partid int, total int, transdate date, remark varchar(200));
	set @i = 1;
	set @max = (select COUNT(partid) from @partstmp );
	declare @cekPartDetailParent as int;
	
	
	while (@i <= @max)
	begin
		set @partidtmp = (select partid from @partstmp where rowid = @i );
		set @partnotmp = (select partno from @partstmp where rowid = @i );
		set @cekPartDetail = (select COUNT(id) from part_details where part_id = @partidtmp and trans_date = (select max(trans_date) from part_details where part_id = @partidtmp));
		if (@cekPartDetail != 0 )
		begin
			set @totalDelivery = (select top 1 total_delivery from part_details where part_id = @partidtmp and trans_date = (select max(trans_date) from part_details where part_id = @partidtmp) order by total_delivery desc );
			--	kondisi a
			set @cekPck31 = (select COUNT(id) from pck31s where part_no = @partnotmp and convert(varchar(8), convert(date, input_date), 112) = convert(varchar(8), getdate()-1, 112));
			if (@cekPck31 != 0)
			begin
				--select 'ada';
				set @totalDeliveryPck31 = (select SUM(qty) from pck31s where part_no = @partnotmp and convert(varchar(8), convert(date, input_date), 112) = convert(varchar(8), getdate()-1, 112));
				--select @totalDelivery;
				--select @totalDeliveryPck31;
				set @totalDelivery = @totalDelivery + @totalDeliveryPck31;
				--select @totalDelivery;
			end;

			insert into @summarytemp (partid , total , transdate , remark )
			select @partidtmp, @totalDelivery, convert(varchar(10), getdate(), 120), 'Tidak Punya Parent';
		end
		else 
		begin
			
			--cek pck31,
			set @partDofvTmp = (select datefirstval from @partstmp where rowid = @i );
			set @cekPck31 = ( select COUNT(id) from pck31s where part_no = @partnotmp and convert(varchar(8), convert(date, input_date), 112) between convert(varchar(8), @partDofvTmp, 112) and convert(varchar(8), getdate()-1, 112));

			-- jika ada, maka input
			if (@cekPck31 > 0)
			begin
			  	set @totalDeliveryPck31 = (select SUM(qty) from pck31s where part_no = @partnotmp and convert(varchar(8), convert(date, input_date), 112) between convert(varchar(8), @partDofvTmp, 112) and convert(varchar(8), getdate()-1, 112));		
				insert into @summarytemp (partid , total , transdate , remark )
				select @partidtmp, @totalDeliveryPck31, convert(varchar(10), getdate(), 120), 'tidak ada detail sebelumnya';
			end
			--jika tidak ada, maka cek parent
			else
			begin
				set @partIdParentTmp = (select isnull(parentpartid,0) from @partstmp where rowid = @i );
				if (@partIdParentTmp != 0)
				begin
				    set @partNoParentTmp = (select parentpartno from @partstmp where rowid = @i );
					set @partDofvParentTmp =  (select parentdofv from @partstmp where rowid = @i );
					set @cekPartDetailParent = (select COUNT(id) from part_details where part_id = @partIdParentTmp and trans_date = (select max(trans_date) from part_details));
					if (@cekPartDetailParent != 0)
					begin
					  set @totalDelivery = (select top 1 total_delivery from part_details where part_id = @partIdParentTmp and trans_date = (select max(trans_date) from part_details) order by total_delivery desc );
						
					  set @cekPck31 = (select COUNT(id) from pck31s where part_no = @partNoParentTmp and convert(varchar(8), convert(date, input_date), 112) = convert(varchar(8), getdate()-1, 112));
					  if (@cekPck31 != 0)
					  begin
						set @totalDeliveryPck31 = (select SUM(qty) from pck31s where part_no = @partNoParentTmp and convert(varchar(8), convert(date, input_date), 112) = convert(varchar(8), getdate()-1, 112));
						
						set @totalDelivery = @totalDelivery + @totalDeliveryPck31;
					  end;

  					  insert into @summarytemp (partid , total , transdate , remark )
					  select @partidtmp, @totalDelivery, convert(varchar(10), getdate(), 120), 'Punya Parent';
					end
					else
					begin
					  set @cekPck31 = (select COUNT(qty) from pck31s where part_no = @partNoParentTmp and convert(varchar(8), convert(date, input_date), 112) between convert(varchar(8), @partDofvParentTmp, 112) and convert(varchar(8), getdate()-1, 112));
					  if (@cekPck31 > 0 )
					  begin
						set @totalDeliveryPck31 = (select SUM(qty) from pck31s where part_no = @partNoParentTmp and convert(varchar(8), convert(date, input_date), 112) between convert(varchar(8), @partDofvParentTmp, 112) and convert(varchar(8), getdate()-1, 112));
					  end
					  else
					  begin
					    set @totalDeliveryPck31 = 0;
					  end;
					  -- @summaryOfTotalDelivery = summary dari total delivery parent part;
					  insert into @summarytemp (partid , total , transdate , remark )
				      select @partidtmp , @totalDeliveryPck31 , convert(varchar(10), getdate(), 120), 'punya parent part id';
					
					end;
				end;
			end;
			  
			
		end;
			
		set @i = @i + 1;
	end;

	--	Step 4 - insert ke part detail
	insert into part_details (part_id, total_delivery, total_qty, trans_date, created_at)
	select partid, sum(total), 0, convert(varchar(10), getdate(), 120), getdate() from @summarytemp group by partid, remark;
end;