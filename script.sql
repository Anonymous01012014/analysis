USE [travel_time]
GO
/****** Object:  Table [dbo].[highway]    Script Date: 7/8/2014 2:10:19 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[highway](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](50) NULL,
	[type] [int] NULL,
	[start_station] [int] NULL,
	[end_station] [int] NULL,
 CONSTRAINT [PK_highway] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[neighbor]    Script Date: 7/8/2014 2:10:19 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[neighbor](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[distance] [real] NULL,
	[station_id] [int] NULL,
	[neighbor_id] [int] NULL,
 CONSTRAINT [PK_neighbor] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[passing]    Script Date: 7/8/2014 2:10:19 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[passing](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[passing_time] [datetime] NULL,
	[traveller_id] [int] NULL,
	[station_id] [int] NULL,
 CONSTRAINT [PK_passing] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[station]    Script Date: 7/8/2014 2:10:19 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[station](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[station_id] [nvarchar](50) NULL,
	[longitude] [real] NULL,
	[latitude] [real] NULL,
	[status] [int] NULL,
	[start_date] [date] NULL,
	[end_date] [date] NULL,
	[highway_id] [int] NULL,
 CONSTRAINT [PK_station] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[travel]    Script Date: 7/8/2014 2:10:19 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[travel](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[travel_time] [bigint] NULL,
	[is_valid] [bit] NULL,
	[passing_from] [int] NULL,
	[passing_to] [int] NULL,
 CONSTRAINT [PK_travel] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[traveller]    Script Date: 7/8/2014 2:10:19 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[traveller](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[mac_address] [nvarchar](50) NULL,
	[device_type] [int] NULL,
	[vehicle_type] [int] NULL,
 CONSTRAINT [PK_traveller] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  View [dbo].[segment_travel_time]    Script Date: 7/8/2014 2:10:19 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[segment_travel_time]
AS
SELECT        AVG(dbo.travel.travel_time) AS travel_time, COUNT(dbo.travel.travel_time) AS travel_count, dbo.highway.name AS highway, [from].station_id AS from_station, 
                         [to].station_id AS to_station, [from].id AS from_station_id, [to].id AS to_station_id, dbo.highway.id AS highway_id, dbo.neighbor.distance
FROM            dbo.travel INNER JOIN
                         dbo.passing AS pass_from ON dbo.travel.passing_from = pass_from.id INNER JOIN
                         dbo.station AS [from] ON pass_from.station_id = [from].id INNER JOIN
                         dbo.highway ON [from].highway_id = dbo.highway.id INNER JOIN
                         dbo.passing AS pass_to ON dbo.travel.passing_to = pass_to.id INNER JOIN
                         dbo.station AS [to] ON pass_to.station_id = [to].id AND dbo.highway.id = [to].highway_id AND [from].highway_id = [to].highway_id INNER JOIN
                         dbo.neighbor ON [from].id = dbo.neighbor.station_id AND [to].id = dbo.neighbor.neighbor_id
WHERE        (dbo.travel.is_valid = 1) AND (dbo.travel.is_valid = 1)
GROUP BY dbo.highway.id, dbo.highway.name, [from].id, [from].station_id, [to].id, [to].station_id, dbo.neighbor.distance

GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = -206
         Left = 0
      End
      Begin Tables = 
         Begin Table = "travel"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 135
               Right = 224
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "pass_from"
            Begin Extent = 
               Top = 6
               Left = 262
               Bottom = 135
               Right = 448
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "from"
            Begin Extent = 
               Top = 198
               Left = 38
               Bottom = 327
               Right = 224
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "highway"
            Begin Extent = 
               Top = 138
               Left = 262
               Bottom = 267
               Right = 448
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "pass_to"
            Begin Extent = 
               Top = 270
               Left = 38
               Bottom = 399
               Right = 224
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "to"
            Begin Extent = 
               Top = 270
               Left = 262
               Bottom = 399
               Right = 448
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "neighbor"
            Begin Extent = 
               Top = 212
               Left = 486
               Bottom = 341
               Right = 672
            End
            DisplayFlags = 280
  ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'segment_travel_time'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane2', @value=N'          TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 12
         Column = 1440
         Alias = 1680
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'segment_travel_time'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=2 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'segment_travel_time'
GO
