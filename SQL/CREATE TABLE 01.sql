USE [OI562]
GO

/****** Object:  Table [dbo].[Zamer]    Script Date: 17.05.2021 16:11:28 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[Zamer_01](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Field] [varchar](50) NULL,
	[date_time] [datetime] NOT NULL,
	[date_time2] [datetime] NOT NULL,
	[Bush] [varchar](50) NULL,
	[Well] [varchar](50) NULL,
	[Time_m] [varchar](50) NULL,
	[Rejim] [varchar](50) NULL,
	[Method_obv] [varchar](50) NULL,
	[Dol_mech_prim_Read] [real] NULL,
	[Konc_hlor_sol_Read] [real] NULL,
	[Dol_ras_gaz_Read] [real] NULL,
	[vlaj_oil_Read] [real] NULL,
	[Dol_ras_gaz_mass] [real] NULL,
	[Dens_gaz_KGN] [real] NULL,
	[Mass_brutto_Accum] [real] NULL,
	[Mass_netto_Accum] [real] NULL,
	[Volume_Count_Forward_sc_Accum] [real] NULL,
	[Mg_GK] [real] NULL,
	[Vg_GK] [real] NULL,
	[Mass_Gaz_UVP_Accum] [real] NULL,
	[WC5_Accum] [real] NULL,
	[Mass_water_UIG_Accum] [real] NULL,
	[Mass_KG] [real] NULL,
	[V_KG] [real] NULL,
	[Debit_liq] [real] NULL,
	[Debit_gas_in_liq] [real] NULL,
	[Debit_cond] [real] NULL,
	[Debit_gaz] [real] NULL,
	[Debit_KG] [real] NULL,
	[Debit_water] [real] NULL,
	[Clean_Gaz] [real] NULL,
	[Clean_Cond] [real] NULL,
	[V_Gaz] [real] NULL,
	[V_Cond] [real] NULL,
	[V_Water] [real] NULL,
	[av] [varchar](50) NULL,
	[TT100] [real] NULL,
	[PT100] [real] NULL,
	[PT201] [real] NULL,
	[PDT200] [real] NULL,
	[PT202] [real] NULL,
	[PT300] [real] NULL,
	[LT300] [real] NULL,
	[TT300] [real] NULL,
	[TT500] [real] NULL,
	[PT500] [real] NULL,
	[TT700] [real] NULL,
	[PT700] [real] NULL,
	[FS_P] [real] NULL,
	[FS_T] [real] NULL,
	[FS_Qw] [real] NULL,
	[FS_Qs] [real] NULL,
	[RT_Dens] [real] NULL,
	[RT_Vlaj] [real] NULL
) ON [PRIMARY]
GO

