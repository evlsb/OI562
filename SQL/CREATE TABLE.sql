USE [OI562]
GO

/****** Object:  Table [dbo].[Zamer]    Script Date: 17.05.2021 16:11:28 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[Zamer](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Field] [varchar](50) NULL,
	[date_time] [datetime] NOT NULL,
	[date_time2] [datetime] NOT NULL,
	[Bush] [varchar](50) NULL,
	[Well] [varchar](50) NULL,
	[Time_m] [varchar](50) NULL,
	[Rejim] [varchar](50) NULL,
	[Method_obv] [varchar](50) NULL,
	[Dol_mech_prim_Read] [varchar](50) NULL,
	[Konc_hlor_sol_Read] [varchar](50) NULL,
	[Dol_ras_gaz_Read] [varchar](50) NULL,
	[vlaj_oil_Read] [varchar](50) NULL,
	[Dol_ras_gaz_mass] [varchar](50) NULL,
	[Dens_gaz_KGN] [varchar](50) NULL,
	[Mass_brutto_Accum] [varchar](50) NULL,
	[Mass_netto_Accum] [varchar](50) NULL,
	[Volume_Count_Forward_sc_Accum] [varchar](50) NULL,
	[Mg_GK] [varchar](50) NULL,
	[Vg_GK] [varchar](50) NULL,
	[Mass_Gaz_UVP_Accum] [varchar](50) NULL,
	[WC5_Accum] [varchar](50) NULL,
	[Mass_water_UIG_Accum] [varchar](50) NULL,
	[Mass_KG] [varchar](50) NULL,
	[V_KG] [varchar](50) NULL,
	[Debit_liq] [varchar](50) NULL,
	[Debit_gas_in_liq] [varchar](50) NULL,
	[Debit_cond] [varchar](50) NULL,
	[Debit_gaz] [varchar](50) NULL,
	[Debit_KG] [varchar](50) NULL,
	[Debit_water] [varchar](50) NULL,
	[Clean_Gaz] [varchar](50) NULL,
	[Clean_Cond] [varchar](50) NULL,
	[V_Gaz] [varchar](50) NULL,
	[V_Cond] [varchar](50) NULL,
	[V_Water] [varchar](50) NULL,
	[av] [varchar](50) NULL,
	[TT100] [varchar](50) NULL,
	[PT100] [varchar](50) NULL,
	[PT201] [varchar](50) NULL,
	[PDT200] [varchar](50) NULL,
	[PT202] [varchar](50) NULL,
	[PT300] [varchar](50) NULL,
	[LT300] [varchar](50) NULL,
	[TT300] [varchar](50) NULL,
	[TT500] [varchar](50) NULL,
	[PT500] [varchar](50) NULL,
	[TT700] [varchar](50) NULL,
	[PT700] [varchar](50) NULL,
	[FS_P] [varchar](50) NULL,
	[FS_T] [varchar](50) NULL,
	[FS_Qw] [varchar](50) NULL,
	[FS_Qs] [varchar](50) NULL,
	[RT_Dens] [varchar](50) NULL,
	[RT_Vlaj] [varchar](50) NULL
) ON [PRIMARY]
GO

