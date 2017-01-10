sql:
extract data from json

-- bing --
SELECT
"SchoolID",
"raw"->'resourceSets'->0->'resources'->0->'address'->'formattedAddress' as "formattedaddress",
"raw"->'resourceSets'->0->'resources'->0->'address'->'postalCode' as "postcode",
"raw"->'resourceSets'->0->'resources'->0->'address'->'confidence' as "confidence",
"raw"->'resourceSets'->0->'resources'->0->'address'->'entityType' as "entitytype",
"raw"->'resourceSets'->0->'resources'->0->'address'->'geocodePoints'->0->'calculationMethod' as "calculationmethod",
"raw"->'resourceSets'->0->'resources'->0->'address'->'geocodePoints'->0->'coordinates'->0 as "latitude",
"raw"->'resourceSets'->0->'resources'->0->'address'->'geocodePoints'->0->'coordinates'->1 as "lngitude",
"raw"->'resourceSets'->0->'resources'->0->'address'->'matchCodes' as "matchcodes"
"raw"->'resourceSets'->0->'resources'->0->'point'->'coordinates'->0 as "latitudeP",
"raw"->'resourceSets'->0->'resources'->0->'point'->'coordinates'->1 as "lngitudeP"
FROM "public"."sc_bing" 
